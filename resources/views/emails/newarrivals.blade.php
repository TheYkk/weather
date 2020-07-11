@component('mail::message')
# Weather report for {{$message->name}}

Temp: {{round($message->main->temp - 273.15,1)}}°C

Humidity: {{$message->main->humidity}}

Pressure: {{$message->main->pressure}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
