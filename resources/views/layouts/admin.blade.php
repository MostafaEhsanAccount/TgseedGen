<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TgseedGen') }} — Admin</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="page">
            <header class="navbar navbar-expand-md navbar-dark d-print-none" style="background:#16213A;">
                <div class="container-xl">
                    <a href="{{ route('admin.dashboard') }}" class="navbar-brand navbar-brand-autodark pe-0 pe-md-3">
                        TgseedGen <span class="badge bg-orange-lt ms-2">Super Admin</span>
                    </a>

                    <div class="navbar-nav flex-row order-md-last">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-none d-xl-block ps-2">
                                    <div>{{ Auth::user()->name }}</div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <a href="{{ route('dashboard') }}" class="dropdown-item">رجوع لواجهة التينانت</a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="page-wrapper">
                @isset($header)
                    <div class="page-header d-print-none">
                        <div class="container-xl">
                            {{ $header }}
                        </div>
                    </div>
                @endisset

                <div class="page-body">
                    <div class="container-xl">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
