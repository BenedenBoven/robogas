{{--
    Veelgestelde vragen per thema, als uitklapbare rijen. Uit het ontwerp: Accordion.
    Gebouwd op <details>, zodat het zonder JavaScript en met het toetsenbord werkt.
    Rendert niets zonder thema's.

    @var Collection<FaqTheme> $faqThemes     @uses geërfde scope van de view
    @var string|null          $faqEyebrow    kicker boven elk thema  @uses meegegeven bij @include
--}}
@if($faqThemes->isNotEmpty())
    <section class="py-24 2xl:py-32 relative">
        <div class="w-full sm:w-[calc(100%-64px)] h-full absolute left-0 bottom-0 z-1 sm:mx-8 bg-blue-light-200"></div>
        <div class="max-w-6xl mx-auto relative z-10 flex flex-col gap-16">
            @foreach($faqThemes as $faqTheme)
                <div>
                    <div class="mb-6">
                        @include('components.section-heading', [
                            'headingTitle'   => $faqTheme->title,
                            'headingEyebrow' => $faqEyebrow ?? 'Veelgestelde vragen',
                        ])
                    </div>
                    <div class="border-b border-grey-300">
                        @foreach($faqTheme->faqs as $faqItem)
                            <details class="group border-t border-grey-300">
                                <summary class="flex items-center justify-between gap-4 py-5 cursor-pointer list-none [&::-webkit-details-marker]:hidden font-heading font-extrabold text-lg text-black hover:text-blue transition-colors duration-300">
                                    <h3 class="text-lg font-extrabold text-inherit">{{ $faqItem->title }}</h3>
                                    <i class="fa-regular fa-angle-down shrink-0 text-blue transition-transform duration-300 group-open:rotate-180" aria-hidden="true"></i>
                                </summary>
                                {!! editable($faqItem, 'body', 'div', 'page-content pb-6 max-w-[62ch]') !!}
                            </details>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
