@component('mail::message')
# Подтверждение Email

Перейдите по ссылке для подтверждения email адреса:

@component('mail::button', ['url' => route('vinograd.register.verify', ['token' => $user->verify_token])])
Подтвердить Email
@endcomponent

Спасибо,<br>
{{ config('app.name') }}
@endcomponent
