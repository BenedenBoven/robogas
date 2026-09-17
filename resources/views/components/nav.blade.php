{{--
    Hoofdnavigatie: menu uit Atom, mega-menu onder Diensten en Doelgroepen, de knoppen
    Gas bestellen en Mijn Robogas, en het mobiele menu. Het gedrag staat in resources/js/nav.js.

    @var Collection<Taxonomy>                                    $navigationItems  @uses MainNavigationComposer
    @var array<int, array{heading: string, links: list<array>}>  $megaMenus        per taxonomy-id  @uses MainNavigationComposer
    @var list<array{label: string, url: string}>                 $arrangeLinks     @uses MainNavigationComposer
    @var Page|null                                               $orderPage        @uses MainNavigationComposer
    @var string|null                                             $portalUrl        @uses MainNavigationComposer
    @var Taxonomy|null                                           $taxonomy         @uses geërfde scope van de view
--}}
@php
    // Een menu-item is actief als de huidige pagina eronder valt.
    // aria-current alleen op de pagina zelf, niet op het item erboven.
    $navActiveIds = isset($taxonomy) ? $taxonomy->breadcrumb()->pluck('id')->map(fn($id) => (int)$id)->all() : [];
    $navCurrentId = isset($taxonomy) ? (int)$taxonomy->id : null;
@endphp
<nav class="fixed top-0 w-full z-50 transition-transform navbar bg-white shadow-xl" id="nav">
    <div class="mx-auto max-w-7xl relative">
        <div class="flex h-22 xl:h-27 justify-between relative">
            <div class="flex shrink-0 items-center">
                <a href="/" class="group" title="Ga naar home">
                    <svg id="nav-logo" class="h-8 xl:h-10 w-auto origin-left transition-all duration-150" viewBox="0 0 287.6 51.7">
                        <g>
                            <path class="fill-black nav-blue"
                                  d="M49.9,23.8h4.7c1.3,0,2.3-.3,2.9-.9s1-1.5,1-2.7-.3-2-1-2.6c-.7-.6-1.6-1-2.9-1h-4.7s0,7.2,0,7.2ZM57.7,43.1l-6.8-12.7h-1v12.7h-9.6V8.6h15.1c2.8,0,5.1.5,7,1.4,1.9,1,3.4,2.3,4.3,4,1,1.7,1.5,3.6,1.5,5.6s-.6,4.4-1.9,6.2c-1.3,1.8-3.2,3-5.6,3.8l7.8,13.4h-10.7Z"/>
                            <path class="fill-black nav-blue"
                                  d="M95.8,32.1c1.4-1.6,2.1-3.7,2.1-6.4s-.7-4.9-2.1-6.5-3.3-2.4-5.8-2.4-4.4.8-5.8,2.4c-1.4,1.6-2.1,3.7-2.1,6.5s.7,4.8,2.1,6.4,3.3,2.4,5.8,2.4,4.4-.8,5.8-2.4M81.1,41.1c-2.7-1.5-4.8-3.6-6.4-6.3-1.6-2.7-2.4-5.7-2.4-9.1s.8-6.4,2.4-9.1,3.7-4.8,6.4-6.3c2.7-1.5,5.7-2.2,8.9-2.2s6.2.8,8.9,2.2c2.7,1.5,4.8,3.6,6.4,6.3,1.6,2.7,2.3,5.7,2.3,9.1s-.8,6.4-2.3,9.1c-1.6,2.7-3.7,4.8-6.4,6.3-2.7,1.5-5.7,2.3-8.9,2.3s-6.2-.8-8.9-2.3"/>
                            <path class="fill-black nav-blue"
                                  d="M131.7,32.3c0-1-.3-1.8-.9-2.4-.6-.5-1.5-.8-2.7-.8h-5.5v6.2h5.6c2.4,0,3.6-1,3.6-3M122.5,22.3h4.8c2.4,0,3.6-1,3.6-3s-1.2-3.1-3.6-3.1h-4.8v6.1ZM139.7,28.4c1.2,1.5,1.8,3.3,1.8,5.3,0,2.9-1,5.2-3,6.9s-4.9,2.5-8.5,2.5h-17.1V8.6h16.5c3.5,0,6.3.8,8.3,2.4,2,1.6,3,3.8,3,6.6s-.5,3.7-1.6,5.1c-1.1,1.3-2.5,2.3-4.2,2.8,2,.5,3.6,1.5,4.8,3"/>
                            <path class="fill-black nav-blue"
                                  d="M168.9,32.1c1.4-1.6,2.1-3.7,2.1-6.4s-.7-4.9-2.1-6.5-3.4-2.4-5.8-2.4-4.4.8-5.8,2.4c-1.4,1.6-2.1,3.7-2.1,6.5s.7,4.8,2.1,6.4c1.4,1.6,3.3,2.4,5.8,2.4s4.4-.8,5.8-2.4M154.2,41.1c-2.7-1.5-4.9-3.6-6.4-6.3-1.6-2.7-2.4-5.7-2.4-9.1s.8-6.4,2.4-9.1,3.7-4.8,6.4-6.3c2.7-1.5,5.7-2.2,8.9-2.2s6.2.8,8.9,2.2,4.8,3.6,6.4,6.3c1.6,2.7,2.4,5.7,2.4,9.1s-.8,6.4-2.4,9.1c-1.6,2.7-3.7,4.8-6.4,6.3-2.7,1.5-5.7,2.3-8.9,2.3s-6.2-.8-8.9-2.3"/>
                            <path class="fill-black nav-blue"
                                  d="M208,20c-.6-.9-1.3-1.6-2.3-2.1s-2.1-.7-3.4-.7c-2.4,0-4.3.8-5.7,2.4-1.4,1.6-2.1,3.7-2.1,6.3s.7,5.2,2.2,6.8,3.6,2.3,6.5,2.3,5.8-1.5,7.2-4.5h-9.6v-6.9h17.9v9.3c-.8,1.8-1.9,3.5-3.3,5.1-1.4,1.6-3.3,2.9-5.5,3.9-2.2,1-4.7,1.5-7.6,1.5s-6.5-.7-9.2-2.2c-2.6-1.5-4.7-3.5-6.2-6.2s-2.2-5.7-2.2-9.1.7-6.4,2.2-9.1c1.4-2.6,3.5-4.7,6.1-6.2,2.6-1.5,5.7-2.2,9.1-2.2s7.9,1,10.8,3.1,4.6,4.9,5.3,8.5h-10.3,0Z"/>
                            <path class="fill-black nav-blue" d="M243.3,30.1l-3.7-11.1-3.7,11.1h7.4ZM245.7,37.4h-12.2l-1.9,5.6h-10.1l12.6-34.5h11l12.5,34.5h-10.1l-1.9-5.6h0Z"/>
                            <path class="fill-black nav-blue"
                                  d="M264.9,40.5c-2.6-1.9-4-4.6-4.1-8.2h10.2c.1,1.2.5,2.1,1.1,2.6s1.4.8,2.4.8,1.6-.2,2.2-.7.9-1,.9-1.8-.5-1.8-1.4-2.3c-.9-.5-2.5-1.2-4.6-1.9-2.2-.8-4.1-1.5-5.5-2.2-1.4-.7-2.6-1.7-3.6-3.1-1-1.3-1.5-3.1-1.5-5.3s.5-4.1,1.7-5.7c1.1-1.6,2.6-2.8,4.6-3.6,2-.8,4.2-1.2,6.6-1.2,4,0,7.2.9,9.6,2.8,2.4,1.9,3.7,4.5,3.8,7.9h-10.4c0-1-.4-1.8-1-2.3s-1.4-.8-2.3-.8-1.3.2-1.8.6c-.5.4-.7,1-.7,1.8s.2,1.2.8,1.7c.5.5,1.1.9,1.9,1.2.8.3,1.9.8,3.3,1.3,2.2.8,4,1.5,5.4,2.2,1.4.7,2.6,1.8,3.7,3.1,1,1.3,1.5,3,1.5,5s-.5,3.9-1.5,5.5-2.5,2.9-4.5,3.9c-1.9,1-4.2,1.4-6.9,1.4-4,0-7.3-1-9.9-2.9"/>
                        </g>
                        <g>
                            <path class="fill-blue-light" d="M14.3,0L4.1,10.2c-5.5,5.5-5.5,14.4,0,20l10.2-10.2c5.5-5.5,5.5-14.4,0-20"/>
                            <path class="fill-blue-light" d="M9.5,51.7l15.2-15.2c5.5-5.5,5.5-14.4,0-20l-15.2,15.2c-5.5,5.5-5.5,14.4,0,20"/>
                        </g>
                    </svg>
                </a>
            </div>

            <div class="hidden xl:flex items-center mainnav gap-8">
                @foreach($navigationItems as $navItem)
                    @php $navMega = $megaMenus[$navItem->id] ?? null; @endphp
                    @if($navMega)
                        <div class="group h-full">
                            <a href="{{ $navItem->url }}" @if($navItem->id === $navCurrentId) aria-current="page" @endif @class([
                                'inline-flex items-center h-full services-dropdown-trigger font-heading font-extrabold',
                                'text-blue' => in_array($navItem->id, $navActiveIds, true),
                                'text-black' => !in_array($navItem->id, $navActiveIds, true),
                            ])>
                                <span class="group-hover:text-blue font-heading">{{ $navItem->title }}</span>
                            </a>
                            <div class="invisible opacity-0 group-hover:opacity-100 group-hover:visible group-focus-within:opacity-100 group-focus-within:visible transition-all fixed left-1/2 -translate-x-1/2 w-[100vw] bg-grey z-40 shadow-xl">
                                <div class="w-1/3 h-full absolute top-0 right-0 bg-yellow z-1"></div>
                                <div class="mx-auto max-w-7xl py-16 grid grid-cols-2 gap-32 relative z-20">
                                    <div>
                                        <span class="block text-black text-2xl lg:text-3xl 2xl:text-4xl font-heading font-black italic mb-8">{{ $navMega['heading'] }}</span>
                                        <div class="flex flex-wrap gap-4">
                                            @foreach($navMega['links'] as $navMegaLink)
                                                <a href="{{ $navMegaLink['url'] }}" class="btn btn-primary">{{ $navMegaLink['label'] }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                    @if($arrangeLinks)
                                        <div>
                                            <span class="block text-black text-2xl lg:text-3xl 2xl:text-4xl font-heading font-black italic mb-8">Direct regelen</span>
                                            <div class="flex flex-wrap gap-4">
                                                @foreach($arrangeLinks as $navArrangeLink)
                                                    <a href="{{ $navArrangeLink['url'] }}" class="btn btn-secondary">{{ $navArrangeLink['label'] }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ $navItem->url }}" @if($navItem->id === $navCurrentId) aria-current="page" @endif @class([
                            'inline-flex items-center hover:text-blue group font-heading font-extrabold',
                            'text-blue' => in_array($navItem->id, $navActiveIds, true),
                            'text-black' => !in_array($navItem->id, $navActiveIds, true),
                        ])>{{ $navItem->title }}</a>
                    @endif
                @endforeach
            </div>
            <div class="-mr-2 flex items-center xl:hidden">
                <button id="mobile-menu-toggle"
                        type="button"
                        class="relative inline-flex items-center justify-center bg-pearl rounded-full p-2 text-black hover:text-blue focus:ring-0 focus:outline-hidden"
                        aria-controls="mobile-menu"
                        aria-expanded="false">

                    <svg class="block size-8" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>

                    <svg class="hidden size-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="static xl:relative">
            <div class="absolute top-24 xl:top-0 right-0 flex flex-col items-end gap-2 xl:flex-row xl:items-center pointer-events-auto translate-x-1">
                @if($orderPage)
                <div class="relative flex items-center overflow-hidden drop-shadow-lg translate-x-[calc(100%-3rem)] hover:translate-x-0 xl:translate-x-0 transition-transform duration-300 group">
                    <a href="{{ $orderPage->url }}" class="absolute inset-0 z-20 cursor-pointer" aria-label="Gas bestellen"></a>
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center bg-black group-hover:bg-blue transition-all duration-300 rounded-l-xl xl:rounded-lb-xl xl:rounded-tl-none">
                    <i class="fa-solid fa-fire text-white"></i>
                </span>
                    <span class="whitespace-nowrap text-sm ps-1 -translate-x-1 pe-4 font-extrabold font-heading uppercase bg-black group-hover:bg-blue transition-all duration-300 text-white h-12 flex items-center xl:rounded-br-xl">
                    Gas bestellen
                </span>
                </div>
                @endif

                @if($portalUrl)
                <div class="relative flex items-center overflow-hidden drop-shadow-lg translate-x-[calc(100%-3rem)] hover:translate-x-0 xl:translate-x-0 transition-transform duration-300 group">
                    <a href="{{ $portalUrl }}" class="absolute inset-0 z-20 cursor-pointer" aria-label="Mijn Robogas"></a>
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center bg-yellow group-hover:bg-blue-light transition-all duration-300 rounded-l-xl xl:rounded-lb-xl xl:rounded-tl-none">
                    <i class="fa-etch fa-solid fa-user text-black group-hover:text-white transition-all duration-300"></i>
                </span>
                    <span class="whitespace-nowrap text-sm ps-1 -translate-x-1 pe-4 font-extrabold font-heading uppercase bg-yellow group-hover:bg-blue-light group-hover:text-white transition-all duration-300 text-black h-12 flex items-center xl:rounded-br-xl">
                    Mijn Robogas
                </span>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div id="mobile-menu" class="opacity-0 max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="pt-8 pb-12 flex flex-col gap-5">
                @foreach($navigationItems as $navItem)
                    @php $navMega = $megaMenus[$navItem->id] ?? null; @endphp
                    <div class="flex flex-col gap-3">
                        <a href="{{ $navItem->url }}" @class([
                            'inline-flex items-center font-heading font-extrabold text-xl hover:text-blue',
                            'text-blue' => in_array($navItem->id, $navActiveIds, true),
                            'text-black' => !in_array($navItem->id, $navActiveIds, true),
                        ])>{{ $navItem->title }}</a>
                        @if($navMega && $navMega['links'])
                            <div class="flex flex-wrap gap-3">
                                @foreach($navMega['links'] as $navMegaLink)
                                    <a href="{{ $navMegaLink['url'] }}" class="btn btn-secondary shadow-none">{{ $navMegaLink['label'] }}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
                @if($arrangeLinks)
                    <div class="flex flex-col gap-3 pt-2">
                        <span class="font-heading font-extrabold text-xl text-black">Direct regelen</span>
                        <div class="flex flex-wrap gap-3">
                            @foreach($arrangeLinks as $navArrangeLink)
                                <a href="{{ $navArrangeLink['url'] }}" class="btn btn-dark shadow-none">{{ $navArrangeLink['label'] }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>
