{{--
    Sticky zijbalk naast een leeskolom of formulier. Uit het ontwerp: Aside.

    @var string      $asideTitle                @uses meegegeven bij @include
    @var string|null $asideBody                 @uses meegegeven bij @include
    @var string|null $asideCtaLabel             @uses meegegeven bij @include
    @var string|null $asideCtaUrl               @uses meegegeven bij @include
--}}
<div class="relative">
    <div class="sticky top-36 bg-blue-light-200 p-8 xl:p-12 rounded-4xl">
        <div class="page-content">
            <h5 class="font-bold uppercase text-black">{{ $asideTitle }}</h5>
            @if(!empty($asideBody))
                <p>{{ $asideBody }}</p>
            @endif
        </div>
        @if(!empty($asideCtaLabel) && !empty($asideCtaUrl))
            <a href="{{ $asideCtaUrl }}" class="btn btn-primary">{{ $asideCtaLabel }}</a>
        @endif
    </div>
</div>
