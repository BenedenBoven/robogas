{{--
    "Wat er hierna gebeurt": genummerde stappen onder een formulier. Uit het ontwerp: NextSteps.
    Rendert niets zonder stappen.

    @var Collection<Step> $nextSteps  @uses meegegeven bij @include
--}}
@if($nextSteps->isNotEmpty())
    <section class="pb-24 2xl:pb-32 bg-white">
        <ol class="max-w-6xl mx-auto relative z-10 grid md:grid-cols-3 gap-8">
            @foreach($nextSteps as $nextStep)
                <li class="border-t-3 border-blue-light-300 pt-4">
                    <span class="block font-heading font-extrabold text-sm text-blue">{{ str_pad((string)$loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3 class="font-heading font-bold text-xl text-black mt-1 mb-1.5">{{ $nextStep->title }}</h3>
                    @if($nextStep->summary)
                        <p>{{ $nextStep->summary }}</p>
                    @endif
                </li>
            @endforeach
        </ol>
    </section>
@endif
