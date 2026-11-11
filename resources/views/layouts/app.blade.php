<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@1,6..96,600&family=Parisienne&family=Pinyon+Script&family=Allura&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/salon.css') }}" rel="stylesheet">
    @stack('head')
</head>
<body>
<header class="site-header">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('catalog.index') }}" class="brand">{{ config('app.name') }}</a>
        <nav class="site-nav">
            <a href="{{ route('client.lookup') }}">{{ __('My appointments') }}</a>
            <span class="lang">
                <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
                <a href="{{ route('lang.switch', 'fr') }}" class="ms-1 {{ app()->getLocale() === 'fr' ? 'active' : '' }}">FR</a>
            </span>
        </nav>
    </div>
</header>

<main class="container py-5">
    @yield('content')
</main>

<footer class="site-footer">
    <div class="container">&copy; {{ date('Y') }} {{ config('app.name') }}</div>
</footer>

@stack('scripts')
</body>
</html>