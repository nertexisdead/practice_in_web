<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    @vite(['resources/scss/app.scss'])
    @livewireStyles
    @stack('css')
</head>
<body class="hold-transition sidebar-mini pace-primary">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link sidebar-toggle d-flex align-items-center" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('frontend.home') }}" class="nav-link pl-0">Frontend</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form class="form-inline" method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <div class="input-group input-group-sm">
                        <button @click.prevent="$root.submit();" class="btn btn-navbar" type="submit">
                            {{ __('Log Out') }}
                        </button>
                    </div>
                </form>
            </li>
        </ul>
    </nav>

    @include('backend.parts.menu')

    <div class="content-wrapper">
        @if (isset($title))
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>{{ $title }}</h1>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section class="content">
            <div class="container-fluid pt-3">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </section>
    </div>
</div>

@livewireScripts
@vite(['resources/js/app.js'])
@stack('js')
</body>
</html>
