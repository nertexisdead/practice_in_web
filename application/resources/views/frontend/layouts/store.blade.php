<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800|space-grotesk:500,700&display=swap" rel="stylesheet"/>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body class="storefront">
@php($canAccessAdmin = auth()->check() && auth()->user()->hasRole('admin', 'superadmin'))

<div class="storefront__background"></div>

<header class="store-header">
    <div class="store-shell store-header__inner">
        <a href="{{ route('frontend.home') }}" class="store-logo" aria-label="Главная страница магазина">
            <span class="store-logo__mark">TL</span>
            <span class="store-logo__text">
                <strong>Torque Lane</strong>
                <small>интернет-магазин автодеталей</small>
            </span>
        </a>

        <nav class="store-nav" aria-label="Основная навигация">
            <a href="{{ route('frontend.home') }}" class="{{ request()->routeIs('frontend.home') ? 'is-active' : '' }}">Главная</a>
            <a href="{{ route('frontend.catalog') }}" class="{{ request()->routeIs('frontend.catalog') ? 'is-active' : '' }}">Каталог</a>
        </nav>

        <div class="store-header__actions">
            @if ($canAccessAdmin)
                <a href="{{ route('admin.dashboard') }}" class="store-button store-button--ghost">Админка</a>
            @endif

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="store-button store-button--dark">Выйти</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="store-button store-button--ghost">Войти</a>
                <a href="{{ route('register') }}" class="store-button store-button--accent">Регистрация</a>
            @endauth
        </div>
    </div>
</header>

<main class="store-main">
    @yield('content')
</main>

<footer class="store-footer">
    <div class="store-shell store-footer__inner">
        <div>
            <p class="store-footer__brand">Torque Lane</p>
            <p class="store-footer__text">Современная витрина магазина автозапчастей с чистым каталогом, быстрым поиском и акцентом на ассортимент.</p>
        </div>

        <div class="store-footer__links">
            <a href="{{ route('frontend.home') }}">Главная</a>
            <a href="{{ route('frontend.catalog') }}">Каталог</a>
            @auth
                @if ($canAccessAdmin)
                    <a href="{{ route('admin.dashboard') }}">Панель управления</a>
                @endif
            @else
                <a href="{{ route('login') }}">Войти</a>
            @endauth
        </div>
    </div>
</footer>
</body>
</html>
