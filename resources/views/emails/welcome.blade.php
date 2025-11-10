@component('mail::message')
# Welcome to TrigStoreGh, {{ $user->name }}!

We're excited to have you on board.  
Your account has been successfully created.

@component('mail::button', ['url' => config('app.url')])
Login Now
@endcomponent

If you have any questions, feel free to reach out to our support team.

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent