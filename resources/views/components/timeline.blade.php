{{--
    Tijdlijn met mijlpalen. Uit het ontwerp: Timeline. Het jaartal staat in
    het label van de regel; zie StepList::MILESTONES. Op een telefoon loopt de
    lijn verticaal. Zonder mijlpalen rendert hij niets.

    @var Collection<int, Step> $timelineItems    @uses meegegeven bij @include
    @var string|null           $timelineTitle    @uses meegegeven bij @include
    @var string|null           $timelineEyebrow  @uses meegegeven bij @include
    @var string|null           $timelineIntro    html uit de editor  @uses meegegeven bij @include
--}}
@if($timelineItems->isNotEmpty())
    <section class="py-24 2xl:py-32 bg-white">
        <div class="max-w-6xl mx-auto relative z-10">
            @if(!empty($timelineTitle))
                @include('components.section-heading', ['headingTitle' => $timelineTitle, 'headingEyebrow' => $timelineEyebrow ?? null])
            @endif
            @if(!empty($timelineIntro))
                <div class="page-content mt-5 max-w-[62ch] [&>p:last-child]:mb-0">{!! $timelineIntro !!}</div>
            @endif

            <ol class="mt-12 flex flex-col lg:flex-row gap-10 lg:gap-6">
                @foreach($timelineItems as $timelineItem)
                    <li class="relative lg:flex-1 pl-10 lg:pl-0">
                        {{-- Stip met lijn: verticaal naast de tekst, vanaf lg horizontaal erboven. --}}
                        <span class="absolute left-0 top-1 lg:static flex lg:items-center h-full lg:h-4" aria-hidden="true">
                            <span class="size-4 shrink-0 rounded-full bg-blue"></span>
                            @unless($loop->last)
                                <span class="absolute left-[0.4rem] top-4 bottom-[-2.5rem] w-[3px] bg-blue-light-300 lg:static lg:h-[3px] lg:w-auto lg:grow"></span>
                            @endunless
                        </span>
                        @if($timelineItem->label)
                            <span class="block lg:mt-5 font-heading font-extrabold text-4xl leading-none text-blue">{{ $timelineItem->label }}</span>
                        @endif
                        <h3 class="mt-2 mb-1 font-heading font-bold text-xl text-black">{{ $timelineItem->title }}</h3>
                        @if($timelineItem->summary)
                            <p class="m-0">{{ $timelineItem->summary }}</p>
                        @endif
                    </li>
                @endforeach
            </ol>
        </div>
    </section>
@endif
