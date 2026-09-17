{{--
    Afbeelding uit de mediabibliotheek, met afmetingen zodat de pagina niet verspringt.
    Zonder media valt hij terug op de standaardfoto.

    @var Media|null  $media                                   @uses meegegeven bij @include
    @var string|null $format  xs, sm, md, lg of xl             @uses meegegeven bij @include
    @var string|null $class                                   @uses meegegeven bij @include
    @var string|null $alt     leeg als het beeld niets toevoegt @uses meegegeven bij @include
    @var bool|null   $eager   true voor beeld boven de vouw     @uses meegegeven bij @include
--}}
@php
    $mediaFormat     = $format ?? 'md';
    $mediaDimensions = $media?->dimensions($mediaFormat);
@endphp
<img src="{{ $media?->{$mediaFormat} ?? Vite::asset('resources/img/default.jpg') }}"
     alt="{{ $alt ?? '' }}"
     @if($mediaDimensions) width="{{ $mediaDimensions['width'] }}" height="{{ $mediaDimensions['height'] }}" @endif
     @if(!empty($eager)) fetchpriority="high" @else loading="lazy" decoding="async" @endif
     class="{{ $class ?? '' }}"/>
