{{--
    Kerncijfers over de volle breedte. Uit het ontwerp: StatStrip (tone brand).
    Het getal staat in het label van de regel, de omschrijving in de titel;
    zie StepList::FACTS. Zonder cijfers rendert hij niets.

    @var Collection<int, Step> $statItems  @uses meegegeven bij @include
--}}
@if($statItems->isNotEmpty())
    <section class="bg-blue py-16">
        <div class="max-w-6xl mx-auto relative z-10 flex flex-col sm:flex-row gap-8">
            @foreach($statItems as $statItem)
                <div class="sm:flex-1">
                    @if($statItem->label)
                        <span class="block font-heading font-extrabold text-6xl lg:text-7xl leading-none text-white">{{ $statItem->label }}</span>
                    @endif
                    <span class="block mt-2 font-heading font-bold uppercase text-sm text-yellow">{{ $statItem->title }}</span>
                </div>
            @endforeach
        </div>
    </section>
@endif
