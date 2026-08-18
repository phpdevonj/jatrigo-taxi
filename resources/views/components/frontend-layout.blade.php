@php
    $app_settings = $app_settings ?? App\Models\AppSetting::first() ?? new App\Models\AppSetting;
    $site_name = $app_settings->site_name ?: config('app.name', 'Laravel');
    $site_description = $app_settings->site_description ?: $site_name;
    $site_favicon = getMediaFileExit($app_settings, 'site_favicon')
        ? getSingleMedia($app_settings, 'site_favicon', false)
        : asset('frontend-website/img/website/logo.png');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $site_name }}</title>

        <link rel="icon" href="{{ $site_favicon }}">

        <!-- Primary Meta Tags -->
        <meta name="title" content="{{ $site_name }}">
        <meta name="description" content="{{ $site_description }}" />

        <!-- Open Graph / Facebook / WhatsApp / Teams -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ $site_name }}">
        <meta property="og:description" content="{{ $site_description }}" />
        <meta property="og:image" content="{{ asset('frontend-website/img/website/preview_img.png') }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="{{ $site_name }}">
        <meta property="twitter:description" content="{{ $site_description }}" />
        <meta property="twitter:image" content="{{ asset('frontend-website/img/website/preview_img.png') }}">

        @include('frontend-partials._head')

    </head>
    <body class="" id="app">

        @include('frontend-partials._body')

    </body>

</html>