<x-frontend-layout :assets="$assets ?? []">
    @php
        $app_settings = $app_settings ?? App\Models\AppSetting::first() ?? new App\Models\AppSetting;
    @endphp

    <div class="container contact-us py-5">

        <!-- Intro -->
        <div class="text-center mb-5">
            <h2 class="mb-3 section-heading-text">Get in Touch</h2>
            <p class="section-para-text">
                We are here to help. Whether you need support with a booking, want to report an issue with a trip,
                or are interested in driving with {{ $app_settings->site_name ?: config('app.name') }}, our team is
                only a call or an email away.
            </p>
        </div>

        <!-- Contact details -->
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-4">
                <a class="contact-card-link" href="{{ $app_settings->contact_number ? 'tel:'.preg_replace('/[^0-9\+]/', '', $app_settings->contact_number) : 'javascript:void(0)' }}">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile"></i>
                        </div>
                        <h5 class="mb-3">Call Us</h5>
                        <p class="feature-para mb-2">
                            Speak with our support team for anything urgent — a ride in progress, a lost item, or a safety concern.
                        </p>
                        @if($app_settings->contact_number)
                            <span class="contact-card-value">{{ $app_settings->contact_number }}</span>
                        @endif
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-md-6 mb-4">
                <a class="contact-card-link" href="{{ $app_settings->contact_email ? 'mailto:'.$app_settings->contact_email : 'javascript:void(0)' }}">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5 class="mb-3">Email Us</h5>
                        <p class="feature-para mb-2">
                            Send us the details of your query and we will respond as quickly as we can, usually within one business day.
                        </p>
                        @if($app_settings->contact_email)
                            <span class="contact-card-value">{{ $app_settings->contact_email }}</span>
                        @endif
                    </div>
                </a>
            </div>
        </div>

        <!-- What to include -->
        <div class="row align-items-center pt-4">
            <div class="col-lg-12 about-section-right">
                <h6 class="small-title mb-2">Before You Reach Out</h6>
                <h2 class="large-title mb-4">Help Us Help You Faster</h2>
                <p class="abt-para mb-4">
                    To resolve your query in a single reply, please include your registered phone number, the date and
                    approximate time of the trip, and the pickup and drop-off locations. If your query is about a payment,
                    adding the amount charged helps us trace it straight away.
                </p>
                <p class="abt-para">
                    For lost belongings, contact us as soon as you notice the item is missing — we will pass your details
                    on to the driver directly. For safety-related concerns, please call rather than email so the team can
                    act on it immediately.
                </p>
            </div>
        </div>

        <!-- Social -->
        <div class="text-center pt-4">
            <h2 class="mb-3 section-heading-text">Follow Us</h2>
            <p class="section-para-text mb-3">
                Stay up to date with service updates, offers, and announcements.
            </p>
            <div class="social-links">
                <a class="social-icon" href="{{ $app_settings->facebook_url ?: 'javascript:void(0)' }}" {!! $app_settings->facebook_url ? 'target="_blank"' : '' !!}><i class="fab fa-facebook-f"></i></a>
                <a class="social-icon" href="{{ $app_settings->instagram_url ?: 'javascript:void(0)' }}" {!! $app_settings->instagram_url ? 'target="_blank"' : '' !!}><i class="fab fa-instagram"></i></a>
                <a class="social-icon" href="{{ $app_settings->twitter_url ?: 'javascript:void(0)' }}" {!! $app_settings->twitter_url ? 'target="_blank"' : '' !!}><i class="fab fa-twitter"></i></a>
                <a class="social-icon" href="{{ $app_settings->linkedin_url ?: 'javascript:void(0)' }}" {!! $app_settings->linkedin_url ? 'target="_blank"' : '' !!}><i class="fab fa-linkedin"></i></a>
            </div>
        </div>

    </div>

</x-frontend-layout>
