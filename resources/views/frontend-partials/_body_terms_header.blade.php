@php
    $app_settings = $app_settings ?? App\Models\AppSetting::first() ?? new App\Models\AppSetting;
    $site_logo = getMediaFileExit($app_settings, 'site_logo')
        ? getSingleMedia($app_settings, 'site_logo', false)
        : asset('frontend-website/img/website/logo.png');
@endphp

<section class="terms-condition-hero-section">
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
                    Terms & Conditions
                </h1>
                <p class="lead text-white mb-4 banner-para">
                    Please read these terms and conditions carefully before using our taxi service. By using our app, you agree to be bound by these terms.
                </p>
                </div>
            </div>
        </div>
    </div>
</section>