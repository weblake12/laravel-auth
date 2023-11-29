@component('mail::message')
# {{ __('Hello :name', ['name' => $data['name']]) }}

{{ __('You received this email because you requested to reset the app account password :app_name', ['app_name' => config('app.name')]) }}

@component('mail::button', ['url' => $data['link']])
    {{ __('Reset your password') }}
@endcomponent

{{ __('This password reset link for your account will expire in :token_expiration minutes.', ['token_expiration' => secondes_to_minutes(config('app.token_expiration'))]) }} 

{{ __('Cordially') }},<br>
{{ config('app.name') }}
@endcomponent