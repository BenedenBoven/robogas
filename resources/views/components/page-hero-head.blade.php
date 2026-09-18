{{--
    Kruimelpad, kicker, h1 en intro van de paginaheader.

    @var bool        $heroDark      @uses meegegeven door components.page-hero
    @var string      $heroVariant   @uses meegegeven door components.page-hero
    @var string      $heroTitle     @uses geërfde scope van de view
    @var string|null $heroEyebrow   @uses geërfde scope van de view
    @var string|null $heroIntro     @uses geërfde scope van de view
    @var string|null $heroAppend    @uses geërfde scope van de view
--}}
@include('components.breadcrumbs', ['tone' => $heroDark ? 'dark' : 'light'])

@if(!empty($heroEyebrow))
    <span @class(['font-heading font-bold uppercase', 'text-yellow' => $heroDark, 'text-blue' => !$heroDark])>{{ $heroEyebrow }}</span>
@endif

{{-- Lange Nederlandse woorden ("propaaninstallaties") passen op een telefoon niet op één regel: afbreken, en anders knippen. --}}
<h1 @class([
    'font-heading font-bold leading-[1.05] text-pretty hyphens-auto break-words',
    'text-5xl md:text-6xl max-w-[24ch]' => $heroVariant === 'band',
    'text-5xl md:text-7xl max-w-[16ch]' => $heroVariant === 'split',
    'text-5xl md:text-7xl max-w-[18ch]' => $heroVariant === 'photo',
    'text-white' => $heroDark,
    'text-black' => !$heroDark,
])>{{ $heroTitle }}</h1>

@if(!empty($heroIntro))
    <p @class(['max-w-[54ch] text-lg', 'text-white' => $heroDark, 'text-black' => !$heroDark])>{{ $heroIntro }}</p>
@endif

@if(!empty($heroAppend))
    @include($heroAppend)
@endif
