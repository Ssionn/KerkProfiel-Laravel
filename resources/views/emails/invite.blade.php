@component('mail::message')
# Je bent uitgenodigd om lid te worden van {{ $team->name }}!

@component('mail::button', ['url' => $url, 'color' => 'primary'])
Uitnodiging accepteren
@endcomponent

@if (isset($url))
Als je de knop niet kan klikken, kopieer dan de volgende URL in de adresbalk van je browser:
{{ $url }}
@endif

Bedankt,<br>
{{ config('app.name') }}
@endcomponent
