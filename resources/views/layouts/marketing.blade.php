<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TgseedGen') }}</title>

        @vite([app()->getLocale() === 'ar' ? 'resources/css/app-rtl.css' : 'resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <header class="navbar navbar-expand-md navbar-light d-print-none border-bottom">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#marketing-navbar-menu" aria-controls="marketing-navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <a href="{{ route('marketing.home') }}" class="navbar-brand navbar-brand-autodark pe-0 pe-md-3">
                    {{ config('app.name', 'TgseedGen') }}
                </a>

                <div class="navbar-nav flex-row order-md-last">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">{{ __('marketing.go_to_dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-link">{{ __('marketing.login') }}</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">{{ __('marketing.get_started') }}</a>
                    @endauth
                </div>

                <div class="collapse navbar-collapse" id="marketing-navbar-menu">
                    <div class="navbar navbar-light">
                        <div class="container-xl">
                            <ul class="navbar-nav">
                                <li class="nav-item {{ request()->routeIs('marketing.home') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('marketing.home') }}">{{ __('marketing.nav_home') }}</a>
                                </li>
                                <li class="nav-item {{ request()->routeIs('marketing.features') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('marketing.features') }}">{{ __('marketing.nav_features') }}</a>
                                </li>
                                <li class="nav-item {{ request()->routeIs('marketing.pricing') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('marketing.pricing') }}">{{ __('marketing.nav_pricing') }}</a>
                                </li>
                                <li class="nav-item {{ request()->routeIs('marketing.blog.*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('marketing.blog.index') }}">{{ __('marketing.nav_blog') }}</a>
                                </li>
                                <li class="nav-item {{ request()->routeIs('marketing.contact') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('marketing.contact') }}">{{ __('marketing.nav_contact') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        <footer class="footer footer-transparent d-print-none">
            <div class="container-xl">
                <div class="row text-center align-items-center flex-row-reverse flex-wrap-reverse">
                    <div class="col-lg-auto ms-lg-auto">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item"><a href="{{ route('marketing.terms') }}" class="link-secondary">{{ __('marketing.nav_terms') }}</a></li>
                            <li class="list-inline-item"><a href="{{ route('marketing.privacy') }}" class="link-secondary">{{ __('marketing.nav_privacy') }}</a></li>
                            <li class="list-inline-item"><a href="{{ route('marketing.cookiePolicy') }}" class="link-secondary">{{ __('marketing.nav_cookie_policy') }}</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item">
                                &copy; {{ date('Y') }} {{ config('app.name', 'TgseedGen') }}. {{ __('marketing.rights_reserved') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
