{{--
    Beeld over de volle breedte. Uit het ontwerp: ImageBand. Zonder beeld rendert hij niets.

    @var Media|null  $bandMedia                      @uses meegegeven bij @include
    @var string|null $bandHeight  Tailwind-hoogte     @uses meegegeven bij @include
--}}
@if($bandMedia)
    <section class="pb-24 2xl:pb-32 bg-white">
        <div class="max-w-7xl mx-auto relative z-10">
            @include('components.media-img', [
                'media'  => $bandMedia,
                'format' => 'xl',
                'class'  => 'block w-full ' . ($bandHeight ?? 'h-80 lg:h-120') . ' object-cover rounded-4xl',
            ])
        </div>
    </section>
@endif
