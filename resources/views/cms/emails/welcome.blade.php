@component('mail::message')
# Greetings

Hi, {{$admin->name}}.

@component('mail::panel')
Welcome in Tasks System
@endcomponent


@component('mail::button', ['url' => 'http://localhost:8000/cms/admin/login'])
Open Tasks System
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
