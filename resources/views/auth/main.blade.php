<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title . ' | ' . config('app.name') }}</title>
        <link href="{{ asset('assets/fonts/nunito.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/cute-alert/cute-alert.css') }}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
        @stack('css')
    </head>
    <body class="antialiased">
        @yield('content')
        <script src="{{ asset('assets/plugins/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/bootstrap/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/cute-alert/cute-alert.js') }}"></script>
        <script>
            var time_alert_success = 2000;
            var time_alert_error = 3000;

        </script>
        @if (App::isLocale('fr'))
            <script>

                var noservice = function (pagename = null) {
                    cuteToast({
                        type: 'error',
                        message: 'La page ' +((pagename != null) ? pagename:'')+ ' ne fonctionne pas pour le moment.',
                        timer: time_alert_error
                    })
                }

            </script>
        @elseif (App::isLocale('en'))
            <script>

                var noservice = function (pagename = null) {
                    cuteToast({
                        type: 'error',
                        message: 'This page ' +((pagename != null) ? pagename:'')+ ' isn\'t working.',
                        timer: time_alert_error
                    })
                }

            </script>
        @endif
        <script>

            var clean_errors = function () {
                if ($('input').hasClass('input-error')) {
                    $('input').removeClass('input-error');
                }
                $('span.error').html('');
            }

            var display_errors = function (errors) {
                console.log(errors);
                for (const field in errors) {
                    if (Object.hasOwnProperty.call(errors, field)) {
                        const element = errors[field];
                        $('[name="' + field + '"]').addClass('input-error');
                        $('span#error-' + field).text(element);
                    }
                }
            }

            $('form.card').submit(function (event) {
                event.preventDefault();

                clean_errors();

                var $form = $(this);
                var formdata = window.FormData ? new FormData($form[0]) : null;
                var data = formdata !== null ? formdata : $form.serialize();

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    }
                });
                $.ajax({
                    processData: false,
                    contentType: false,
                    data: data,
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    success: function(result) {
                        console.log('!! result form');
                        console.log(result);

                        if (result.action == true) {
                            cuteToast({
                                type: 'success',
                                message: result.message,
                                timer: (result.href) ? time_alert_success:10000
                            }).then(() => {
                                if (result.href)
                                    location.href = result.href;
                            });
                        }
                        else {
                            if (result.message) {
                                cuteToast({
                                    type: 'error',
                                    message: result.message,
                                    timer: time_alert_error
                                });
                            }
                            if (result.errors) {
                                display_errors(result.errors);
                            }
                        }
                    }
                });
            });

        </script>
        @stack('js')
    </body>
</html>
