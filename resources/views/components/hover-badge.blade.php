{{--
    Klein labeltje dat bij hover boven een knop of label verschijnt, zoals
    "Gas voor" boven een doelgroep. Het element zelf komt uit de slot-view.

    @var string $badgeText  @uses meegegeven bij @include
--}}
<span class="pointer-events-none absolute -top-3 left-2 z-10 whitespace-nowrap bg-black text-yellow font-heading font-bold uppercase text-[0.65rem] leading-none px-2 py-1 opacity-0 translate-y-1 transition-all duration-300 group-hover/badge:opacity-100 group-hover/badge:translate-y-0 group-focus-within/badge:opacity-100 group-focus-within/badge:translate-y-0" aria-hidden="true">{{ $badgeText }}</span>
