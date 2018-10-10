@component('mail::message')
# One last step

We just need to confirm your email address.
{{-- user here is available because it is a public prop on PleaseConfirmYourEmail --}}
@component('mail::button', ['url' => url('/register/confirm?token=' . $user->confirmation_token)])
Click here to confirm email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
