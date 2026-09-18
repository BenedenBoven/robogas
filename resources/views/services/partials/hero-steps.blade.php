{{--
    Compact stappenlint in de header van een dienst: waar deze stap in de aanpak zit.
    Eerdere stappen zijn gedimd, de huidige is geel.

    @var Collection<Service> $services  @uses geërfde scope van de view
    @var Service             $service   @uses geërfde scope van de view
--}}
<nav aria-label="Onze A-tot-Z aanpak" class="mt-8 max-w-4xl">
    <ol class="grid grid-cols-5 gap-2 sm:gap-4">
        @foreach($services as $heroStep)
            @php $heroStepOn = $heroStep->id === $service->id; @endphp
            <li>
                <a href="{{ $heroStep->url }}" @if($heroStepOn) aria-current="step" @endif @class([
                    'group block pt-3 border-t-3 transition-colors duration-300',
                    'border-yellow' => $heroStepOn,
                    'border-white/25 hover:border-white/60' => !$heroStepOn,
                ])>
                    <span @class(['block font-heading font-extrabold text-xs', 'text-yellow' => $heroStepOn, 'text-white/60' => !$heroStepOn])>{{ str_pad((string)$loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <span @class([
                        'hidden sm:block font-heading font-bold text-sm leading-tight mt-0.5 transition-colors duration-300',
                        'text-white' => $heroStepOn,
                        'text-white/70 group-hover:text-white' => !$heroStepOn,
                    ])>{{ $heroStep->title }}</span>
                </a>
            </li>
        @endforeach
    </ol>
</nav>
