@php
    $app_settings = $app_settings ?? App\Models\AppSetting::first() ?? new App\Models\AppSetting;
    $site_logo = getMediaFileExit($app_settings, 'site_logo')
        ? getSingleMedia($app_settings, 'site_logo', false)
        : asset('frontend-website/img/website/logo.png');
@endphp

<section class="contact-us-hero-section">
    <div class="container hero-content">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand tmex-logo" href="{{route('browse')}}">
                    <img src="{{ $site_logo }}" alt="{{ $app_settings->site_name }}">
                </a>
            </div>
        </nav>

        <!-- Hero Content -->
        <div class="row align-items-center banner-content" style="min-height: 80vh;">
            <div class="col-lg-12">
                <div class="Privacy-policy-banner-content">
                <h1 class="display-4 text-white mb-4 banner-heading">
                    Contact Us
                </h1>
                <p class="lead text-white mb-4 banner-para">
                    Have a question about a ride, your account, or driving with us? Reach out through any of the details below and our support team will get back to you.
                </p>
                </div>
            </div>
        </div>
    </div>
</section>
