<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('description', __('Braids for women and men. Choose your style, book online and we will confirm by phone.'))">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Allura&family=Playfair+Display:ital,wght@0,500;0,600;1,500&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/salon.css') }}" rel="stylesheet">
    @stack('head')
</head>
<body>
<header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a href="{{ route('home') }}" class="brand">{{ config('app.name') }}</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('catalog.index') ? 'active' : '' }}" href="{{ route('catalog.index') }}">{{ __('Services') }}</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#about">{{ __('About us') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#contact">{{ __('Contact') }}</a></li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('client.*') ? 'active' : '' }}" href="{{ route('client.lookup') }}">{{ __('My appointments') }}</a>
                    </li>
                    <li class="nav-item">
                        <span class="lang">
                            <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
                            <a href="{{ route('lang.switch', 'fr') }}" class="{{ app()->getLocale() === 'fr' ? 'active' : '' }}">FR</a>
                        </span>
                    </li>
                    <li class="nav-item ms-lg-2 mb-2 mb-lg-0">
                        <a href="{{ route('booking.create') }}" class="btn btn-blush btn-sm px-4">{{ __('Book now') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="@yield('main_class', 'container py-5')">
    @yield('content')
</main>

@php
    $connect = array_filter([
        'Instagram' => config('salon.instagram'),
        'Facebook' => config('salon.facebook'),
        'TikTok' => config('salon.tiktok'),
        'WhatsApp' => config('salon.whatsapp') ? 'https://wa.me/' . preg_replace('/\D/', '', config('salon.whatsapp')) : null,
        __('Email') => config('salon.email') ? 'mailto:' . config('salon.email') : null,
    ]);
@endphp

<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <a href="{{ route('home') }}" class="brand">{{ config('app.name') }}</a>
            <p class="footer-tag">{{ __('Your Braids, Your Beauty') }}</p>
        </div>

        <div>
            <h2 class="footer-title">{{ __('Explore') }}</h2>
            <ul class="list-unstyled mb-0">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('catalog.index') }}">{{ __('Services') }}</a></li>
                <li><a href="{{ route('booking.create') }}">{{ __('Book now') }}</a></li>
                <li><a href="{{ route('client.lookup') }}">{{ __('My appointments') }}</a></li>
            </ul>
        </div>

        @if ($connect)
            <div>
                <h2 class="footer-title">{{ __("Let's connect") }}</h2>
                <ul class="list-unstyled mb-0">
                    @foreach ($connect as $label => $url)
                        <li><a href="{{ $url }}" target="_blank" rel="noopener">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="footer-base">
        <div class="container">&copy; {{ date('Y') }} {{ config('app.name') }}</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>