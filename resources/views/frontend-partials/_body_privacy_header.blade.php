@php
    $app_settings = $app_settings ?? App\Models\AppSetting::first() ?? new App\Models\AppSetting;
    $site_logo = getMediaFileExit($app_settings, 'site_logo')
        ? getSingleMedia($app_settings, 'site_logo', false)
        : asset('frontend-website/img/website/logo.png');
@endphp

<section class="privacy-policy-hero-section">
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
                    Privacy Policy
                </h1>
                <p class="lead text-white mb-4 banner-para">
                    Your privacy is important to us. This policy explains how we collect, use, and protect your personal information when you use our taxi services.
                </p>
                </div>
            </div>
        </div>
    </div>
</section>