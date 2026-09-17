{{--
    Genummerde stappenstrip: slanke variant van het stappenpad, voor pagina's waar
    de stappen context zijn en geen hoofdinhoud. Uit het ontwerp: StepRibbon.

    @var Collection<Service> $services                                @uses geërfde scope van de view
    @var Service|null        $ribbonActive  de stap waar je nu bent    @uses meegegeven bij @include
    @var string|null         $ribbonTone    'dark' of 'tint'           @uses meegegeven bij @include
    @var string|null         $ribbonTitle                             @uses meegegeven bij @include
    @var string|null         $ribbonEyebrow                           @uses meegegeven bij @include
--}}
@php $ribbonDark = ($ribbonTone ?? 'dark') === 'dark'; @endphp
<section class="py-24 2xl:py-32 relative">
    <div @class([
        'w-full sm:w-[calc(100%-64px)] h-full absolute left-0 top-0 z-1 sm:mx-8',
        'bg-black' => $ribbonDark,
        'bg-blue-light-200' => !$ribbonDark,
    ])></div>
    <div class="max-w-6xl mx-auto relative z-10">
        @if(!empty($ribbonTitle))
            <div class="mb-10">
                @include('components.section-heading', [
                    'headingTitle'   => $ribbonTitle,
                    'headingEyebrow' => $ribbonEyebrow ?? null,
                    'headingTone'    => $ribbonDark ? 'dark' : 'light',
                    'headingSize'    => 'text-3xl lg:text-4xl',
                ])
            </div>
        @endif
        <ol class="grid grid-cols-2 md:grid-cols-3 xl:grid-flow-col xl:auto-cols-fr gap-5">
            @foreach($services as $ribbonStep)
                @php $ribbonOn = $ribbonStep->id === ($ribbonActive?->id); @endphp
                <li>
                    <a href="{{ $ribbonStep->url }}" @if($ribbonOn) aria-current="step" @endif @class([
                        'block pt-4 border-t-3 group',
                        'border-yellow' => $ribbonOn && $ribbonDark,
                        'border-blue' => $ribbonOn && !$ribbonDark,
                        'border-white/30' => !$ribbonOn && $ribbonDark,
                        'border-blue-light-300' => !$ribbonOn && !$ribbonDark,
                    ])>
                        <span @class([
                            'block font-heading font-extrabold text-sm',
                            'text-yellow' => $ribbonOn && $ribbonDark,
                            'text-white' => !$ribbonOn && $ribbonDark,
                            'text-blue' => !$ribbonDark,
                        ])>Stap {{ str_pad((string)$loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <span @class([
                            'block font-heading font-bold text-xl leading-tight mt-1 transition-colors duration-300',
                            'text-white group-hover:text-yellow' => $ribbonDark,
                            'text-black group-hover:text-blue' => !$ribbonDark,
                        ])>{{ $ribbonStep->title }}</span>
                    </a>
                </li>
            @endforeach
        </ol>
    </div>
</section>
