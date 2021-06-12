@component('mail::message')
# Welcome to the LMS SaaS App, {{$user->name}}

The body of your message.

@component('mail::button', ['url' => ''])
Welcome
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
