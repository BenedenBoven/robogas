{{--
    Vorige en volgende stap onder een dienstdetail. Uit het ontwerp: PrevNext.

    @var Service|null $previousStep  @uses geërfde scope van de view
    @var Service|null $nextStep      @uses geërfde scope van de view
--}}
@if($previousStep || $nextStep)
    <nav aria-label="Stappen" class="py-24 2xl:py-32 bg-white">
        <div class="max-w-6xl mx-auto relative z-10 grid md:grid-cols-2 gap-6 md:gap-12">
            @foreach(['prev' => $previousStep, 'next' => $nextStep] as $stepDirection => $stepLink)
                @if($stepLink)
                    <a href="{{ $stepLink->url }}" @class([
                        'group bg-white border border-blue-light-300 rounded-3xl p-8 flex flex-col gap-1 transition-colors duration-200 hover:bg-blue-light-200 hover:border-blue',
                        'md:col-start-2 text-right' => $stepDirection === 'next',
                    ])>
                        <span class="font-heading font-bold uppercase text-sm text-blue">
                            @if($stepDirection === 'prev')
                                <i class="fa-regular fa-angle-left mr-1 inline-block transition-transform duration-200 group-hover:-translate-x-1" aria-hidden="true"></i> Vorige stap
                            @else
                                Volgende stap <i class="fa-regular fa-angle-right ml-1 inline-block transition-transform duration-200 group-hover:translate-x-1" aria-hidden="true"></i>
                            @endif
                        </span>
                        <span class="font-heading font-extrabold text-3xl text-black">{{ $stepLink->title }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </nav>
@endif
