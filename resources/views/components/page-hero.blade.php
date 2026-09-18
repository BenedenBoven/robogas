{{--
    Paginaheader in drie varianten uit het ontwerp (PageHero):
    photo — verhalende pagina's met beeld (over ons, doelgroepen, biogas)
    split — tekst naast beeld op lichtblauw (overzichten, contact, artikel, tekstpagina)
    band  — navy band zonder beeld (detail- en formulierpagina's)
    De navigatie staat fixed, daarom schuift de inhoud een navhoogte omlaag.

    @var Taxonomy    $taxonomy                                      @uses geërfde scope van de view
    @var string|null $heroVariant    photo, split of band            @uses meegegeven bij @include
    @var string      $heroTitle                                     @uses meegegeven bij @include
    @var string|null $heroEyebrow                                   @uses meegegeven bij @include
    @var string|null $heroIntro                                     @uses meegegeven bij @include
    @var Media|null  $heroMedia      valt terug op de standaardfoto  @uses meegegeven bij @include
    @var string|null $heroWatermark  groot getal achter een band     @uses meegegeven bij @include
    @var string|null $heroAppend     view onder de intro (knoppen, filters) @uses meegegeven bij @include
--}}
@php
    $heroVariant = $heroVariant ?? 'photo';
    $heroDark    = $heroVariant !== 'split';
@endphp

@if($heroVariant === 'split')
    <header class="bg-blue-light-200">
        <div class="max-w-7xl mx-auto relative z-10 pt-38 xl:pt-43 pb-16 grid lg:grid-cols-[1.05fr_.95fr] gap-10 lg:gap-16 items-center">
            <div class="flex flex-col gap-4">
                @include('components.page-hero-head')
            </div>
            @include('components.media-img', [
                'media'  => $heroMedia ?? null,
                'format' => 'lg',
                'class'  => 'block w-full h-72 lg:h-112 object-cover rounded-t-4xl rounded-bl-4xl',
                'eager'  => true,
            ])
        </div>
    </header>
@elseif($heroVariant === 'band')
    <header class="bg-black relative overflow-hidden">
        @if(!empty($heroWatermark))
            <span class="hidden lg:block absolute right-24 top-1/2 -translate-y-1/3 font-heading font-extrabold text-[22rem] leading-none text-white/7 pointer-events-none" aria-hidden="true">{{ $heroWatermark }}</span>
        @endif
        <div class="max-w-7xl mx-auto relative z-10 pt-38 xl:pt-43 pb-24 flex flex-col gap-4">
            @include('components.page-hero-head')
        </div>
    </header>
@else
    <header class="relative h-160 overflow-hidden bg-blue">
        @include('components.media-img', [
            'media'  => $heroMedia ?? null,
            'format' => 'lg',
            'class'  => 'absolute inset-0 w-full h-full object-cover',
            'eager'  => true,
        ])
        {{-- Sterk genoeg voor een lichte foto: witte tekst moet ook op een zonnige gevel leesbaar blijven. --}}
        <div class="absolute inset-0 bg-linear-to-r from-black/70 via-black/40 via-40% to-black/0 to-70%"></div>
        <div class="mx-auto max-w-7xl">
            <div class="relative z-10 h-160 pt-27 flex flex-col justify-center gap-4">
                @include('components.page-hero-head')
            </div>
        </div>
    </header>
@endif
