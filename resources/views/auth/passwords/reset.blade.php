@extends('auth.main', ['title' => __('Password reset')])
@section('content')
    <main class="px-5">
        <div class="pt-5">
            <a 
                href="{{ route('home') }}" 
                style="display: block" 
                class="h3 text-center my-5 font-weight-bold">{{ config('app.name') }}</a>
                <div class="form-row">
                    <div class="col-md-3 mx-auto">
                        <form method="post" action="{{ route('password.update') }}" class="card">
                            @csrf
                            <div class="card-header">
                                {{ __('Reset password') }}
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="token_hashed" value="{{ $token_hashed }}">
                                <div class="form-row">
                                    <div class="col-12 mb-3">
                                        <label for="email">{{ __('Email address') }}</label> 
                                        <input id="email" type="email" class="form-control" name="email" value="{{ $email }}" placeholder="{{ __('Email address') }}" required autocomplete="email" readonly autofocus>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="password">{{ __('Password') }}</label>
                                        <input id="password" type="password" class="form-control" name="password" placeholder="{{ __('Password') }}" required autocomplete="new-password">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="password-confirm">{{ __('Confirm password') }}</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirm password') }}" required autocomplete="new-password">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('Reset password') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script>

        var init = function () {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });
            $.ajax({
                /*
                processData: false,
                contentType: false,
                */
                type: 'post',
                url: "{{ route('password.reset.store') }}",
                data: {
                    email:"{{ $email }}",
                    token_hashed:"{{ $token_hashed }}",
                },
                success: function(result) {

                    console.log('!! init()');
                    console.log(result);

                    if (result.action == true) {
                        cuteToast({
                            type: 'success',
                            message: result.message,
                            timer: 10000
                        });
                    }
                    else {
                        cuteToast({
                            type: 'error',
                            message: (result.message) ? result.message:"{{ __('Errors') }}",
                            timer: time_alert_error
                        }).then(() => {
                            if (result.href)
                                location.href = result.href;
                        });
                    }
                }
            });
        }

        init();
    </script>
@endpush
