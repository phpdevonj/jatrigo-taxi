@php
    $app_settings = $app_settings ?? App\Models\AppSetting::first() ?? new App\Models\AppSetting;
    $site_logo = getMediaFileExit($app_settings, 'site_logo')
        ? getSingleMedia($app_settings, 'site_logo', false)
        : asset('frontend-website/img/website/logo.png');
@endphp

<header class="header-gradient">
    <div class="container">
        <div class="d-flex align-items-center">
            <div class="d-flex align-items-center">
                <i class="bi bi-car-front-fill fs-2 me-2"></i>
                <div class="tmex-logo">
                    <a href="{{route('browse')}}">
                        <img src="{{ $site_logo }}" alt="{{ $app_settings->site_name }}">
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>