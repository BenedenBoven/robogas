{{--
    Doelgroep als geel label. Als link krijgt hij bij hover het labeltje
    "Gas voor" erboven, zodat "Particulier" leest als "Gas voor Particulier".

    @var Audience    $labelAudience                                       @uses meegegeven bij @include
    @var bool|null   $labelLink   true: een link naar de doelgroep         @uses meegegeven bij @include
    @var string|null $labelTone   Tailwind-klassen voor grond en inkt      @uses meegegeven bij @include
--}}
@php $labelTone = $labelTone ?? 'bg-yellow text-black'; @endphp
@if(!empty($labelLink))
    <span class="relative inline-block group/badge">
        @include('components.hover-badge', ['badgeText' => 'Gas voor'])
        <a href="{{ $labelAudience->url }}" class="inline-block {{ $labelTone }} text-sm font-bold px-3 py-2 font-heading transition-colors duration-300 hover:bg-yellow-400">{{ $labelAudience->title }}</a>
    </span>
@else
    <span class="inline-block {{ $labelTone }} text-sm font-bold px-3 py-2 font-heading">{{ $labelAudience->title }}</span>
@endif
