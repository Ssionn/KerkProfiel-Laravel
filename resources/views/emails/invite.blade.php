@component('mail::message')
<div style="text-align: center; margin-bottom: 30px;">
    <img src="{{ asset('storage/images/logos/kp-logo.jpeg') }}" alt="Logo" style="height: 32px; width: auto;">
</div>

<div style="text-align: center;">
    <h1>Je bent uitgenodigd om lid te worden van {{ $teamName }}!</h1>
</div>

@component('mail::button', ['url' => $url, 'color' => 'primary'])
    Uitnodiging accepteren
@endcomponent

@if (isset($url))
Als je de knop niet kan klikken, kopieer dan de volgende URL in de adresbalk van je browser:
[{{ $url }}]({{ $url }})
@endif

Bedankt,<br>
{{ config('app.name') }}
@endcomponent
