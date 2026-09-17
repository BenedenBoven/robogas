{{--
    Twee acties op een lichtblauwe grond, met één regel uitleg. Uit het ontwerp: ActionPanel.

    @var string      $panelTitle                                        @uses meegegeven bij @include
    @var string|null $panelBody                                         @uses meegegeven bij @include
    @var array       $panelActions  [['label', 'url', 'variant'?, 'icon'?]] @uses meegegeven bij @include
--}}
@if(!empty($panelActions))
    <div class="bg-blue-light-200 rounded-3xl px-8 py-8 xl:px-10 flex flex-wrap gap-8 items-center justify-between">
        <div>
            <span class="block font-heading font-extrabold text-2xl text-black">{{ $panelTitle }}</span>
            @if(!empty($panelBody))
                <p class="mt-1 max-w-[46ch]">{{ $panelBody }}</p>
            @endif
        </div>
        <div class="flex flex-wrap gap-4">
            @foreach($panelActions as $panelIndex => $panelAction)
                <a href="{{ $panelAction['url'] }}" @class([
                    'btn',
                    'btn-' . ($panelAction['variant'] ?? ($panelIndex === 0 ? 'dark' : 'primary')),
                    'btn-down' => !empty($panelAction['icon']),
                ])>
                    @if(!empty($panelAction['icon']))<i class="{{ $panelAction['icon'] }}"></i>@endif
                    {{ $panelAction['label'] }}
                </a>
            @endforeach
        </div>
    </div>
@endif
