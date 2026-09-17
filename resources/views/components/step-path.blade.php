{{--
    Alternerend stappenpad: de hoofdinhoud van het dienstenoverzicht. Uit het ontwerp: StepPath.
    Op mobiel staan alle kaarten rechts van de lijn.

    @var Collection<Service> $services  @uses geërfde scope van de view
--}}
<section class="py-24 2xl:py-32 bg-white">
    <div class="max-w-6xl mx-auto relative z-10">
        <ol class="flex flex-col">
            @foreach($services as $pathStep)
                @php $pathRight = $loop->iteration % 2 === 0; @endphp
                <li class="grid grid-cols-[3.5rem_1fr] md:grid-cols-[1fr_5.5rem_1fr] gap-x-6 md:gap-x-0 items-start">
                    <div @class([
                        'col-start-2 row-start-1',
                        'md:col-start-3' => $pathRight,
                        'md:col-start-1' => !$pathRight,
                        'pb-12' => !$loop->last,
                    ])>
                        <div class="relative bg-white border border-blue-light-300 rounded-3xl p-8 xl:p-10 hover:shadow-xl hover:-translate-y-2 duration-300 transition-all group">
                            <a href="{{ $pathStep->url }}" class="absolute inset-0 z-20" aria-label="{{ $pathStep->title }}"></a>
                            <h2 class="text-2xl xl:text-3xl font-extrabold text-black">
                                <i class="{{ $pathStep->icon_class }} text-blue mr-2" aria-hidden="true"></i>{{ $pathStep->title }}
                            </h2>
                            <div class="page-content mt-3">
                                @if($pathStep->summary)
                                    <p class="mb-4">{{ $pathStep->summary }}</p>
                                @endif
                                @if($pathStep->we_do_items)
                                    <ul class="!mb-0">
                                        @foreach($pathStep->we_do_items as $pathItem)
                                            <li>{{ $pathItem }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-start-1 md:col-start-2 row-start-1 flex flex-col items-center self-stretch">
                        <span class="shrink-0 size-14 rounded-full bg-blue text-white font-heading font-extrabold text-xl flex items-center justify-center">{{ str_pad((string)$loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        @unless($loop->last)
                            <span class="grow w-[3px] bg-blue-light-300" aria-hidden="true"></span>
                        @endunless
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</section>
