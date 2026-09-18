{{--
    Diensten als kaartenraster: icoon, stapnummer als watermerk, samenvatting en
    een knop. Zelfde kaartstijl als de productkaarten op de homepage. De laatste
    tegel is de offerte-CTA, zodat het raster vol loopt zonder los blok eronder.

    @var Collection<Service> $services     @uses geërfde scope van de view
    @var Page|null           $quotePage    @uses geërfde scope van de view
    @var Page|null           $contactPage  @uses geërfde scope van de view
--}}
<section class="py-24 2xl:py-32 bg-white">
    <div class="max-w-6xl mx-auto relative z-10 grid md:grid-cols-2 xl:grid-cols-3 gap-8">
        @foreach($services as $cardService)
            <article class="relative bg-grey rounded-3xl p-8 xl:p-10 shadow-lg hover:shadow-xl hover:-translate-y-2 duration-300 transition-all flex flex-col gap-4 group overflow-hidden">
                <a href="{{ $cardService->url }}" class="absolute inset-0 z-20" aria-label="{{ $cardService->title }}"></a>
                <div class="relative z-10 flex items-start justify-between gap-4">
                    <span class="size-14 rounded-full bg-white text-blue flex items-center justify-center text-xl shadow-sm group-hover:bg-blue group-hover:text-white transition-colors duration-300" aria-hidden="true">
                        <i class="{{ $cardService->icon_class }}"></i>
                    </span>
                    <span class="font-heading font-extrabold text-6xl leading-none text-blue-light-300 group-hover:text-blue-light transition-colors duration-300" aria-hidden="true">{{ str_pad((string)$loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                </div>
                <h2 class="relative z-10 font-light text-4xl text-black">{{ $cardService->title }}</h2>
                @if($cardService->summary)
                    <p class="relative z-10">{{ $cardService->summary }}</p>
                @endif
                <span class="relative z-10 btn btn-primary group-hover:btn-active mt-auto">Bekijk</span>
                <div class="absolute h-full w-full bottom-0 right-0 z-1 overflow-hidden pointer-events-none" aria-hidden="true">
                    <svg class="h-full w-auto ml-auto scale-105" viewBox="0 0 28.9 51.7">
                        <path class="fill-grey-100 group-hover:fill-blue-light/20 transition-all duration-900" d="M14.3,0L4.1,10.2c-5.5,5.5-5.5,14.4,0,20l10.2-10.2c5.5-5.5,5.5-14.4,0-20"/>
                        <path class="fill-grey-100 group-hover:fill-blue-light/20 transition-all duration-900" d="M9.5,51.7l15.2-15.2c5.5-5.5,5.5-14.4,0-20l-15.2,15.2c-5.5,5.5-5.5,14.4,0,20"/>
                    </svg>
                </div>
            </article>
        @endforeach

        @if($quotePage || $contactPage)
            <div class="bg-black rounded-3xl p-8 xl:p-10 flex flex-col gap-2 justify-center">
                <span class="font-heading font-extrabold text-3xl xl:text-4xl text-white leading-tight">Zullen we het doorrekenen?</span>
                <span class="font-heading font-bold uppercase text-yellow">Een prijs op maat</span>
                <div class="flex flex-wrap gap-4 mt-6">
                    @if($quotePage)
                        <a href="{{ $quotePage->url }}" class="btn btn-primary">Offerte aanvragen</a>
                    @endif
                    @if($contactPage)
                        <a href="{{ $contactPage->url }}" class="btn btn-trans">Contact opnemen</a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>
