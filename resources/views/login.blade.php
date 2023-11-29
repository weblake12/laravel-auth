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
        <main class="px-5">
                <div class="mt-5 pt-5">
                    <a href="{{ route('home') }}" style="display: block" class="h3 text-center my-5 font-weight-bold">{{ config('app.name') }}</a>
                    <div class="form-row">
                        <div class="col-lg-3 mx-auto">
                            <form method="post" action="{{ route('login.auth') }}" class="card">
                                @csrf
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-12 mb-3">
                                            <label for="username">@lang('Email or Username') <span class="text-danger">*</span></label>
                                            <input type="text" name="username" class="form-control bg-light" id="username" placeholder="@lang('Email or Username')" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="password">@lang('Password') <span class="text-danger">*</span></label>
                                            <input type="password" name="password" class="form-control bg-light" id="password" placeholder="@lang('Password')" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-sm btn-primary">@lang('Connect us')</button>
                                </div>                                
                            </form>                            
                        </div>
                    </div>
                </div>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/cute-alert/cute-alert.js') }}"></script>
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
                        message: 'This page ' +((pagename != null) ? pagename:'')+ ' is not working.',
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
                                timer: time_alert_success
                            }).then(() => {
                                location.href = result.href
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
    </body>
</html>