<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        <link href="https://fonts.googleapis.com/css?family=Open Sans" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ asset('assets/cute-alert/style.css') }}" rel="stylesheet">
        <style>
            body {
                font-family: 'Open Sans', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <header>
            <nav class="navbar navbar-light bg-light">
                <a class="navbar-brand">{{ config('app.name') }}</a>
                <div class="form-inline">
                    <a class="mr-2" href="{{ route('login') }}">@lang('Login')</a>
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
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/cute-alert/cute-alert.js') }}"></script>
    </body>
</html>