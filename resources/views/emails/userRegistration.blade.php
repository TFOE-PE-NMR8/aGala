@component('mail::message')

Hello {{ $fullName }},

Thank you for joining {{ config('app.name') }}.

We’d like to confirm that your account was created successfully. To access the dashboard click the link below.

@component('mail::button', ['url' => config('app.url')])
    Go to Dashboard
@endcomponent

If you experience any issues logging into your account, reach out to us.

Best, <br/>
The DevBro Solutions team
@endcomponent
