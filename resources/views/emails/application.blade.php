{{-- @formatter:off --}}
{{--
    Sollicitatiemail. Zelfde opbouw als de mail van atom-generic-forms, met de
    vacature en de bestanden erbij.

    @var array<string, string|null>             $post          @uses ApplicationMail
    @var Form                                   $form          @uses ApplicationMail
    @var string                                 $vacancyTitle  @uses ApplicationMail
    @var bool                                   $toHost        @uses ApplicationMail
    @var list<array{name: string, url: string}> $fileLinks     @uses ApplicationMail
--}}
@component('mail::message')
@if($toHost)
Er is gesolliciteerd op de vacature **{{ $vacancyTitle }}**.
@else
Bedankt voor je sollicitatie op de vacature **{{ $vacancyTitle }}**. We hebben alles in goede orde ontvangen en nemen snel contact met je op. Dit heb je ons gestuurd:
@endif
## Gegevens
@component('mail::table', ['class' => 'no-th'])
|                          |                      |
| ------------------------ | -------------------- |
@foreach($form->fields as $field)
|**{{ ucfirst(__('validation.attributes.' . $field)) }}**| {{ $post[$field] ?? 'niet ingevuld' }} |
@endforeach
@endcomponent
@foreach($form->textAreas as $textarea)
@if(!empty($post[$textarea]))
{{ ucfirst(__('validation.attributes.' . $textarea)) }}
@component('mail::panel')
{!! nl2br(e(strip_tags($post[$textarea]))) !!}
@endcomponent
@endif
@endforeach
## Bestanden
@if($toHost)
Log eerst in op Atom; daarna opent de link het bestand.

@foreach($fileLinks as $fileLink)
- [{{ $fileLink['name'] }}]({{ $fileLink['url'] }})
@endforeach
@else
@foreach($fileLinks as $fileLink)
- {{ $fileLink['name'] }}
@endforeach
@endif
@endcomponent
