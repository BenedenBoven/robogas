<!DOCTYPE html>
<html lang="nl">
<head>
    <title>{{ $taxonomy?->meta_title ?? 'META TITEL FIXEN' }}</title>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if (isset($taxonomy?->meta_description))
        <meta name="description" content="{{ $taxonomy->meta_description }}">
    @endif
    @vite(['resources/css/app.css'])
    {!! $atomFrontEndService->getStyles() !!}
    <!-- FAVICON -->
    <meta name="color-scheme" content="light dark">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ Vite::asset('resources/img/favicon/light_favicon-32x32.png') }}?v=2" media="(prefers-color-scheme: light)">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ Vite::asset('resources/img/favicon/dark_favicon-32x32.png') }}?v=2" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/svg+xml" href="{{ Vite::asset('resources/img/favicon/favicon-adaptive.svg') }}?v=2">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ Vite::asset('resources/img/favicon/light_favicon-32x32.png') }}?v=2">
    <link rel="manifest" href="{{ Vite::asset('resources/img/favicon/site.webmanifest') }}?v=2">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ Vite::asset('resources/img/favicon/light_apple-touch-icon.png') }}?v=2">
    <!-- SOCIAL TAGS -->
    <meta property="og:title" content="{{ $taxonomy?->meta_title ?? 'META TITEL FIXEN' }}">
    <meta property="og:description"
          content="{{ isset($taxonomy) ? $taxonomy?->meta_description ?? (strip_tags($taxonomy?->getModel()->getSummary(30)) ?? '') : '' }}">
    <meta property="og:url" content="{{ getHost() }}{{ $taxonomy?->url ?? '/' }}">
</head>
<body class="bg-white">
@include('components.nav')
@include('components.header')
@yield('content')
@include('components.footer')
@vite(['resources/js/app.js'])
@stack('scripts')
{!! $atomFrontEndService->getScripts() !!}
</body>
</html>