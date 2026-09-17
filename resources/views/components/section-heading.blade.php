{{--
    Sectiekop met optionele kicker eronder. Uit het ontwerp: SectionHeading.

    @var string      $headingTitle                              @uses meegegeven bij @include
    @var string|null $headingEyebrow  kicker in hoofdletters    @uses meegegeven bij @include
    @var string|null $headingAlign    'left' of 'center'        @uses meegegeven bij @include
    @var string|null $headingTone     'light' of 'dark' (grond) @uses meegegeven bij @include
    @var string|null $headingSize     Tailwind-klassen voor de grootte @uses meegegeven bij @include
    @var string|null $headingTag      'h2' of 'h3'              @uses meegegeven bij @include
--}}
@php
    $headingTag  = $headingTag ?? 'h2';
    $headingDark = ($headingTone ?? 'light') === 'dark';
@endphp
<div @class(['text-center' => ($headingAlign ?? 'left') === 'center'])>
    <{{ $headingTag }} @class([
        $headingSize ?? 'text-4xl lg:text-5xl',
        'font-extrabold',
        'text-white' => $headingDark,
        'text-black' => !$headingDark,
    ])>{{ $headingTitle }}</{{ $headingTag }}>
    @if(!empty($headingEyebrow))
        <span @class([
            'block font-heading font-bold uppercase leading-snug',
            'text-yellow' => $headingDark,
            'text-blue' => !$headingDark,
        ])>{{ $headingEyebrow }}</span>
    @endif
</div>
