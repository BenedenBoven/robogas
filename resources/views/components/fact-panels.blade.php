{{--
    Panelen met opsommingen naast elkaar. Uit het ontwerp: FactPanels.
    Panelen zonder punten worden overgeslagen; zonder panelen rendert hij niets.

    @var array $factGroups  [['title', 'icon'?, 'tone'? ('brand'), 'items' => list<string>]]  @uses meegegeven bij @include
--}}
@php $factGroups = array_values(array_filter($factGroups, fn(array $group) => !empty($group['items']))); @endphp
@if($factGroups)
    <section class="py-24 2xl:py-32 bg-white">
        <div @class(['max-w-6xl mx-auto relative z-10 grid gap-8', 'lg:grid-cols-2' => count($factGroups) > 1])>
            @foreach($factGroups as $factGroup)
                <div @class([
                    'rounded-3xl p-8 xl:p-10',
                    'bg-blue-light-200' => ($factGroup['tone'] ?? null) === 'brand',
                    'bg-white border border-blue-light-300' => ($factGroup['tone'] ?? null) !== 'brand',
                ])>
                    <h2 class="text-2xl font-extrabold text-black">
                        @if(!empty($factGroup['icon']))<i class="{{ $factGroup['icon'] }} text-blue mr-2" aria-hidden="true"></i>@endif{{ $factGroup['title'] }}
                    </h2>
                    <div class="page-content mt-4">
                        <ul class="!mb-0">
                            @foreach($factGroup['items'] as $factItem)
                                <li>{{ $factItem }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
