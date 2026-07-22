<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'TgseedGen') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="d-flex flex-column">
        <div class="page page-center">
            <div class="container container-tight py-4">
                <div class="text-center mb-4">
                    <span class="navbar-brand navbar-brand-autodark h1">TgseedGen</span>
                </div>
                <div class="card card-md">
                    <div class="card-body text-center">
                        <h2 class="mb-3">نظام توليد العملاء المحتملين والتواصل</h2>
                        <p class="text-secondary mb-4">
                            Laravel {{ app()->version() }} + Tabler (Bootstrap 5، دعم RTL مدمج)
                        </p>
                        @if (Route::has('login'))
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                @auth
                                    <a href="{{ route('dashboard') }}" class="btn btn-primary">لوحة التحكم</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">تسجيل الدخول</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-outline-secondary">إنشاء حساب</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
