<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        <link href="{{ asset('assets/fonts/nunito.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/cute-alert/cute-alert.css') }}" rel="stylesheet">
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <header>
            <nav class="navbar navbar-light bg-light">
                <a class="navbar-brand">{{ config('app.name') }}</a>
                <div class="form-inline">
                    <a class="mr-2" href="{{ route('login') }}">Login</a>
                </div>
            </nav>
        </header>
        <main class="px-5">
            <div class="mt-5 pt-5">
                <div class="mt-5 pt-5">
                    <h3 class="text-center mt-5 font-weight-bold">{{ config('app.name') }}</h3>
                </div>
            </div>
        </main>
        <script src="{{ asset('assets/plugins/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/cute-alert/cute-alert.js') }}"></script>
    </body>
</html>
