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
    <link rel="icon" href="/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <!-- SOCIAL TAGS -->
    <meta property="og:title" content="{{ $taxonomy?->meta_title ?? 'META TITEL FIXEN' }}">
    <meta property="og:description"
          content="{{ isset($taxonomy) ? $taxonomy?->meta_description ?? (strip_tags($taxonomy?->getModel()->getSummary(30)) ?? '') : '' }}">
    <meta property="og:url" content="{{ getHost() }}{{ $taxonomy?->url ?? '/' }}">
</head>
<body>
@include('components.nav')
@yield('content')
@vite(['resources/js/app.js'])
@stack('scripts')
{!! $atomFrontEndService->getScripts() !!}
</body>
</html>