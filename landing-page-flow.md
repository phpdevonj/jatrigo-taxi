# Landing-Page-First Flow (public website on `/` instead of login)

How the default app URL serves a public marketing/landing page instead of bouncing
guests to `/login`, as implemented in **og-taxi-base**, and how to reproduce it in
another Laravel project.

---

## 1. Current status in this repo (read this first)

**ENABLED on branch `jatriogtaxi/sslCommerz-integration` (uncommitted as of 2026-08-10).**
`GET /` serves the public landing page; the admin dashboard lives at `/home`.

Previously it was disabled by two switches, both now flipped:

| # | File | Was | Now |
|---|------|-----|-----|
| 1 | `routes/web.php` | `Route::get('/', [HomeController::class, 'index'])` sat **inside** the `['auth','verified','admin','check.route.permission']` group, so `/` required a logged-in admin; the landing page was parked on `/frontend`. | That route is removed. `/home` (line 74) is the named `home` dashboard route; `/` (line 236) is the public `browse` route. `/frontend` (line 237) still resolves to the same page but is no longer named. |
| 2 | `app/Http/Controllers/Frontendwebsite/FrontendController.php` | `index()` began with `return redirect()->to('login');` — an unconditional short-circuit that made the whole method body dead code. | Line removed; the method builds and returns the view. |

Guests requesting a *protected* URL are still sent to login by `bootstrap/app.php`:

```php
$middleware->redirectGuestsTo(fn () => route('login'));
```

That line is correct in both flows and needs no change.

> The original login-first layout came from the upstream **og-taxi-base** project; §2–§3
> document the reference implementation there, annotated for what actually exists here.

---

## 2. The mechanism

There is **no redirect involved**. The landing page is not something the app
redirects *to* — it is simply what owns the `/` route. Login only appears when the
user asks for a protected URL. Three rules make it work:

### Rule 1 — `/` is registered outside every auth middleware group

At the **bottom** of `routes/web.php`, after the protected admin group closes:

```php
Route::get('/', [FrontendController::class, 'index'])->name('browse');
Route::get('termofservice',   [FrontendController::class, 'termofservice'])->name('termofservice');
Route::get('privacypolicy',   [FrontendController::class, 'privacypolicy'])->name('privacypolicy');
Route::get('page/{slug}',     [FrontendController::class, 'page'])->name('pages');
Route::get('customer-support',[FrontendController::class, 'custmerSupport'])->name('custmerSupport');
Route::post('custmer-support/send', [FrontendController::class, 'custmerSupportSend'])->name('custmerSupport.send');
```

Only the `web` middleware group applies (session, CSRF, `LanguageTranslator`) — no
`auth`, so guests are served the page directly.

### Rule 2 — the admin dashboard moves off `/` to `/home`

Inside the protected group, the `/` route is removed and only `/home` remains:

```php
Route::group(['middleware' => ['auth', 'verified', 'admin', 'check.route.permission']], function () {
    // Route::get('/', [HomeController::class, 'index']);   // <-- must be removed/commented
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    ...
});
```

If you leave the `/` route inside the group it wins (it is registered first) and the
public route at the bottom is never reached.

### Rule 3 — post-login and post-auth redirects must point at `/home`, not `/`

Otherwise a successful login drops the admin straight back onto the marketing page.

`app/Http/Controllers/Auth/AuthenticatedSessionController.php`

```php
public function store(LoginRequest $request)
{
    $request->authenticate();
    $request->session()->regenerate();
    ...
    return redirect(RouteServiceProvider::HOME);   // '/home'  — NOT redirect('/')
}

public function destroy(Request $request)
{
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');                          // logout -> back to landing page
}
```

`app/Http/Middleware/RedirectIfAuthenticated.php`

```php
if (Auth::guard($guard)->check()) {
    return redirect(RouteServiceProvider::HOME);   // already-logged-in user hitting /login
}
```

`app/Providers/RouteServiceProvider.php` (Laravel ≤ 10 skeleton)

```php
public const HOME = '/home';
```

> **Laravel 11/12+ note:** this project has since moved to the slim skeleton and
> `RouteServiceProvider` no longer exists. Replace `RouteServiceProvider::HOME`
> with the literal `'/home'` (or a `config('app.home_url')` value) and keep
> `bootstrap/app.php`'s `redirectGuestsTo(fn () => route('login'))` as-is — that
> line is correct in both flows; it only fires for *protected* URLs.

### Resulting behaviour

| Request | Guest | Logged-in admin |
|---|---|---|
| `GET /` | landing page (200) | landing page (200) |
| `GET /home` | 302 → `/login` | dashboard |
| `GET /login` | login form | 302 → `/home` |
| `POST /login` (success) | 302 → `/home` | — |
| `POST /logout` | — | 302 → `/` (landing page) |
| `GET /driver`, `/rider`, … | 302 → `/login` | page |

---

## 3. What the landing page itself is made of

The page is **fully database-driven** — content is edited from the admin panel, not
hardcoded. Porting the routing rules alone gives you a working flow; porting the
list below gives you the actual page.

### Controller

`app/Http/Controllers/Frontendwebsite/FrontendController.php`

`index()` builds a `$data` array from settings and passes three collections to the
view:

```php
$data['dummy_title']       = DummyData('dummy_title');
$data['dummy_description'] = DummyData('dummy_description');

$data['app_info']     = [ 'app_title', 'image_title', 'backgound_image' ];
$data['download_app'] = [ 'title', 'subtitle', 'play_store', 'app_store', 'download_app_image' ];
$data['our_mission']  = [ 'title', 'our_mission_image' ];
$data['why_choose']   = [ 'title', 'subtitle', 'why_choose_image' ];
$data['client_testimonials'] = [ 'title', 'subtitle' ];

$our_mission = FrontendData::where('type', 'our_mission')->get();
$why_choose  = FrontendData::where('type', 'why_choose')->get();
$items       = FrontendData::where('type', 'client_testimonials')->get();

return view('frontend-website.index', compact('our_mission', 'why_choose', 'items', 'data'));
```

Every value falls back to `DummyData(...)` placeholders, so the page renders even
with an empty `settings` table — useful when standing it up in a fresh project.

### Views

```
resources/views/components/frontend-layout.blade.php   <x-frontend-layout> wrapper
resources/views/frontend-partials/_head.blade.php
resources/views/frontend-partials/_body.blade.php      header + {{ $slot }} + footer + scripts
resources/views/frontend-partials/_body_header.blade.php
resources/views/frontend-partials/_body_footer.blade.php
resources/views/frontend-partials/_scripts.blade.php
resources/views/frontend-website/index.blade.php       the landing page
resources/views/frontend-website/termofservice.blade.php
resources/views/frontend-website/privacy_policy.blade.php
resources/views/frontend-website/pages.blade.php       dynamic CMS pages by slug
resources/views/frontend-website/customer_support.blade.php
```

The layout is intentionally separate from the admin `layouts/dashboard.blade.php` —
the public site loads none of the admin CSS/JS.

### Static assets

```
public/frontend-website/assets/css
public/frontend-website/assets/js
public/frontend-website/img/     (play_store.png, app_store.png, divider_image.png,
                                  favicon.png, and 1920x* placeholder backgrounds)
```

### Models & migrations

| Model | Migration | Role |
|---|---|---|
| `App\Models\Setting` | `2022_05_23_094130_create_settings_table.php` | key/value per `type` (`app_info`, `our_mission`, …) + media |
| `App\Models\FrontendData` | `2024_06_06_073251_create_frontend_data_table.php` | repeatable blocks (`our_mission`, `why_choose`, `client_testimonials`) |
| `App\Models\Pages` | `2024_07_19_132851_create_pages_table.php` | slug-based CMS pages linked in the footer |

Images use `spatie/laravel-medialibrary` collections.

### Helpers (`app/Helpers/helper.php`, autoloaded via `composer.json` `files`)

| Function | Line | Purpose |
|---|---|---|
| `DummyData($key)` | 30 | placeholder text when nothing is configured |
| `getSettingFirstData($type, $key)` | 44 | fetch the `Setting` row (for media) |
| `getSingleMediaSettingImage($model, $collection, $type = null)` | 49 | resolve image URL with fallback |
| `SettingData($type, $key)` | 1385 | scalar setting value |

### Section schema — `config/constant.php` (lines 75–107)

```php
'app_info'            => ['app_name', 'image_title', 'background_image', 'logo_image'],
'our_mission'         => ['title', 'image'],
'download_app'        => ['title', 'subtitle', 'image', 'play_store', 'app_store'],
'contactus_info'      => ['about_title', 'image'],
'client_testimonials' => ['title', 'subtitle', 'image'],
'why_choose'          => ['title', 'subtitle', 'image'],
```

This config drives both the public page and the admin editor — adding a key here
makes it appear in the admin form automatically.

### Admin-side editors (inside the protected route group)

```php
Route::get('website-section/{type}',            [FrontendController::class, 'websiteSettingForm'])->name('frontend.website.form');
Route::post('update-website-information/{type}',[FrontendController::class, 'websiteSettingUpdate'])->name('frontend.website.information.update');
Route::resource('pages',               PagesController::class);
Route::resource('our-mission',         OurMissionController::class);
Route::resource('why-choose',          WhyChooseController::class);
Route::resource('client-testimonials', ClientTestimonialsController::class);
```

`websiteSettingForm` renders `resources/views/websitesection/form.blade.php` from
the `config/constant.php` schema. If you use `CheckRoutePermission`, register these
route names in its map (see `app/Http/Middleware/CheckRoutePermission.php:129-130`,
where both are mapped to the `home` permission).

---

## 4. Porting checklist for a new project

**A. Minimum — just the routing flow (30 minutes)**

1. In `routes/web.php`, comment out / delete `Route::get('/', ...)` from inside the
   `auth` middleware group. Keep `/home` as the named `home` route.
2. Register the public route at the very bottom of `routes/web.php`, outside all
   groups: `Route::get('/', [FrontendController::class, 'index'])->name('browse');`
3. Set the post-login target to `/home` in
   `AuthenticatedSessionController@store` and `RedirectIfAuthenticated@handle`.
   Keep `destroy()` returning `redirect('/')`.
4. Leave guest redirection alone — `redirectGuestsTo(fn () => route('login'))` in
   `bootstrap/app.php` (or `Authenticate::redirectTo()` on older skeletons) is
   already correct.
5. Run `php artisan route:clear && php artisan config:clear && php artisan view:clear`.
   **Cached routes are the #1 reason this appears not to work.**

**B. Full — bring the actual page across**

6. Copy `app/Http/Controllers/Frontendwebsite/FrontendController.php` and delete the
   `return redirect()->to('login');` line on entry to `index()`.
7. Copy the views listed in §3 (`components/frontend-layout.blade.php`,
   `frontend-partials/*`, `frontend-website/*`).
8. Copy `public/frontend-website/` wholesale.
9. Copy models `Setting`, `FrontendData`, `Pages` + their migrations; run `migrate`.
10. Copy the four helper functions and confirm `app/Helpers/helper.php` is in
    `composer.json` → `autoload.files`; then `composer dump-autoload`.
11. Merge the six section blocks into `config/constant.php`.
12. Copy the admin editor routes/controllers (`websiteSettingForm`,
    `websiteSettingUpdate`, `PagesController`, `OurMissionController`,
    `WhyChooseController`, `ClientTestimonialsController`) and add menu entries.
13. Add the `message.*` translation keys used by the footer
    (`privacy_policy`, `terms_conditions`, `terms_of_use`, …).

**Verification**

```bash
php artisan route:list --path=/ --method=GET     # '/' must show no auth middleware
curl -sI http://your-app/        # expect 200, not 302
curl -sI http://your-app/home    # expect 302 -> /login
```

---

## 5. Gotchas

- **Route order.** Laravel matches the first registered route. A `/` inside the auth
  group at line 74 always beats a `/` at line 233. Remove it, don't just add another.
- **Route cache.** `php artisan route:cache` in production freezes the old mapping;
  always `route:clear` after changing this.
- **Post-login loop.** If `store()` returns `redirect('/')` while `/` is public, the
  admin logs in successfully and lands on the marketing page with no visible sign of
  being logged in — the classic symptom of getting Rule 3 wrong.
- **`RouteServiceProvider` is gone on Laravel 11+.** Use the literal `'/home'`.
- **Media library.** `getSingleMediaSettingImage()` returns placeholder images from
  `public/frontend-website/img/` when no upload exists — copy that folder or the
  page renders with broken images.
- **Reverting to login-first** is exactly the two switches in §1: move `/` back into
  the auth group and re-add the early `return redirect()->to('login');`.
