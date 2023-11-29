@extends('auth.main', ['title' => __('Password reset')])
@section('content')
    <main class="px-5">
        <div class="pt-5">
            <a 
                href="{{ route('home') }}" 
                style="display: block" 
                class="h3 text-center my-5 font-weight-bold">{{ config('app.name') }}</a>
            <div class="form-row">
                <div class="col-lg-3 mx-auto">
                    <form method="post" action="{{ route('password.email') }}" class="card">
                        @csrf
                        <div class="card-header">
                            {{ __('Reset your password') }}
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label for="email">{{ __('Email address') }}</label>
                                    <input id="email" type="email" class="form-control" name="email" value="" placeholder="{{ __('Email address') }}" required autocomplete="email" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('login') }}" class="btn btn-warning">{{ __('Login') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Send reinit link') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
