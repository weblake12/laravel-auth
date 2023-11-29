@component('mail::message')
# {{ __('Hello') }},

{{ __('This message is a test') }}

{{ __('Cordially') }},<br>
{{ config('app.name') }}
@endcomponent