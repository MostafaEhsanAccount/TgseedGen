<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TgseedGen') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="page">
            @include('layouts.navigation')

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
