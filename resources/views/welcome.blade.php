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
                        <h2 class="mb-3">تأسيس المشروع</h2>
                        <p class="text-secondary mb-4">
                            Laravel 13 + Tabler (Bootstrap 5, دعم RTL مدمج) شغالين مع بعض بنجاح.
                        </p>
                        <div class="d-flex align-items-center justify-content-center gap-2 mb-4">
                            <span class="badge bg-green-lt">Laravel {{ app()->version() }}</span>
                            <span class="badge bg-purple-lt">Tabler UI</span>
                            <span class="badge bg-blue-lt">RTL</span>
                        </div>
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="tooltip" title="مكونات Bootstrap JS شغالة فعليًا">
                            اختبار زر Tabler
                        </button>
                    </div>
                </div>
                <div class="text-center text-secondary mt-3">
                    الخطوة الجاية: تثبيت Laravel Breeze وربط شاشات الدخول بنفس القالب.
                </div>
            </div>
        </div>
    </body>
</html>
