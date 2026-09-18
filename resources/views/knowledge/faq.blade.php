{{--
    Veelgestelde vragen: alle thema's met hun vragen, links een themalijst om te
    filteren (resources/js/knowledge.js), onderaan het telefoonnummer.

    @var Taxonomy             $taxonomy     @uses ShowFaq
    @var Page                 $page         @uses ShowFaq
    @var Collection<FaqTheme> $faqThemes    @uses ShowFaq
    @var Page|null            $contactPage  @uses ContactPage
    @var CompanyDetails       $company      @uses CompanyDetailsComposer
--}}
@extends('layouts.app')

@section('header')
    @include('components.page-hero', [
        'heroVariant' => 'band',
        'heroTitle'   => $page->long_title,
        'heroEyebrow' => $page->subtitle,
        'heroIntro'   => $page->summary,
    ])
@endsection

@section('content')
    <section class="py-24 2xl:py-32 bg-white">
        <div class="max-w-6xl mx-auto relative z-10 grid lg:grid-cols-[1fr_3fr] gap-12 lg:gap-16 items-start">
            <nav aria-label="Thema's" class="lg:sticky lg:top-36 flex flex-row flex-wrap lg:flex-col gap-y-1" data-faq-rail>
                <button type="button" aria-pressed="true" data-faq-filter="" class="text-left px-4 py-3 border-l-3 font-heading transition-colors duration-300 border-blue text-blue font-extrabold">Alle vragen</button>
                @foreach($faqThemes as $railTheme)
                    <button type="button" aria-pressed="false" data-faq-filter="{{ $railTheme->id }}" class="text-left px-4 py-3 border-l-3 font-heading transition-colors duration-300 border-blue-light-300 text-black font-medium hover:text-blue">{{ $railTheme->title }}</button>
                @endforeach
            </nav>
            <div class="flex flex-col gap-12">
                @foreach($faqThemes as $faqTheme)
                    <div data-faq-group="{{ $faqTheme->id }}">
                        <div class="mb-5">
                            @include('components.section-heading', ['headingTitle' => $faqTheme->title, 'headingSize' => 'text-3xl'])
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
        </div>
    </section>

    <section class="bg-black py-16">
        <div class="max-w-6xl mx-auto relative z-10 flex flex-wrap gap-8 items-center justify-between">
            <div>
                <span class="block font-heading font-bold uppercase text-sm text-yellow">Toch liever even bellen?</span>
                <a href="{{ $company->phoneHref() }}" class="font-heading font-extrabold text-4xl md:text-5xl text-white leading-tight hover:text-yellow transition-colors duration-300">{{ $company->phone() }}</a>
                @if($page->body)
                    {!! editable($page, 'body', 'div', 'page-content text-white mt-3 max-w-[48ch] [&>p:last-child]:mb-0') !!}
                @endif
            </div>
            @if($contactPage)
                <a href="{{ $contactPage->url }}" class="btn btn-primary">Contactgegevens</a>
            @endif
        </div>
    </section>
@endsection
