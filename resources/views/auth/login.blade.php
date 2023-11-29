@extends('auth.main', ['title' => __('Login')])
@section('content')
    <main class="px-5">
        <div class="pt-5">
            <a 
                href="{{ route('home') }}" 
                style="display: block" 
                class="h3 text-center my-5 font-weight-bold">{{ config('app.name') }}</a>
            <div class="form-row">
                <div class="col-lg-3 mx-auto">
                    <form method="post" action="{{ route('login.auth') }}" class="card">
                        @csrf
                        <div class="card-header">
                            {{ __('Connect us') }}
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label for="username">{{ __('Email or Username') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="username" class="form-control bg-light" id="username" placeholder="{{ __('Email or Username') }}" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="password">{{ __('Password') }} <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control bg-light" id="password" placeholder="{{ __('Password') }}" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <a href="{{ route('password.request') }}">{{ __('Forgot password') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-primary">{{ __('Connect us') }}</button>
                        </div>                                
                    </form>                            
                </div>
            </div>
        </div>
    </main>
@endsection
