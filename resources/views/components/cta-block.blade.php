{{--
    Afgerond CTA-blok midden op een pagina. Uit het ontwerp: CTABlock, afgeleid van "Interesse?" in de footer.

    @var string      $ctaTitle                                           @uses meegegeven bij @include
    @var string|null $ctaEyebrow                                         @uses meegegeven bij @include
    @var string|null $ctaBody                                            @uses meegegeven bij @include
    @var string|null $ctaTone     'dark', 'brand', 'accent' of 'tint'    @uses meegegeven bij @include
    @var string|null $ctaAlign    'left' of 'center'                     @uses meegegeven bij @include
    @var array       $ctaActions  [['label', 'url', 'variant'?, 'icon'?]] @uses meegegeven bij @include
--}}
@php
    $ctaTone    = $ctaTone ?? 'dark';
    $ctaOnLight = in_array($ctaTone, ['accent', 'tint'], true);
    $ctaCenter  = ($ctaAlign ?? 'left') === 'center';
@endphp
<div @class([
    'rounded-4xl p-8 md:p-12 flex flex-col gap-2',
    'items-center text-center' => $ctaCenter,
    'items-start' => !$ctaCenter,
    'bg-black' => $ctaTone === 'dark',
    'bg-blue' => $ctaTone === 'brand',
    'bg-yellow' => $ctaTone === 'accent',
    'bg-blue-light-200' => $ctaTone === 'tint',
])>
    <span @class([
        'font-heading text-4xl md:text-5xl font-extrabold leading-tight',
        'text-black' => $ctaOnLight,
        'text-white' => !$ctaOnLight,
    ])>{{ $ctaTitle }}</span>
    @if(!empty($ctaEyebrow))
        <span @class([
            'font-heading font-bold uppercase',
            'text-blue' => $ctaOnLight,
            'text-yellow' => !$ctaOnLight,
        ])>{{ $ctaEyebrow }}</span>
    @endif
    @if(!empty($ctaBody))
        <p @class(['max-w-[52ch] mt-2', 'text-black' => $ctaOnLight, 'text-white' => !$ctaOnLight])>{{ $ctaBody }}</p>
    @endif
    @if(!empty($ctaActions))
        <div class="flex flex-wrap gap-4 mt-6">
            @foreach($ctaActions as $ctaIndex => $ctaAction)
                <a href="{{ $ctaAction['url'] }}" @class([
                    'btn',
                    'btn-' . ($ctaAction['variant'] ?? ($ctaIndex === 0 ? 'primary' : 'secondary')),
                    'btn-down' => !empty($ctaAction['icon']),
                ])>
                    @if(!empty($ctaAction['icon']))<i class="{{ $ctaAction['icon'] }}"></i>@endif
                    {{ $ctaAction['label'] }}
                </a>
            @endforeach
        </div>
    @endif
</div>
