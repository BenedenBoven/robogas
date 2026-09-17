{{--
    Contact: formulier naast de bedrijfsgegevens, met een kaart eronder.

    @var Taxonomy             $taxonomy   @uses ShowFormPage
    @var Page                 $page       @uses ShowFormPage
    @var FormType             $formType   @uses ShowFormPage
    @var Collection<FaqTheme> $faqThemes  @uses ShowFormPage
    @var Page|null            $quotePage  @uses QuotePage
    @var Page|null            $orderPage  @uses OrderPage
    @var CompanyDetails       $company    @uses CompanyDetailsComposer
--}}
@extends('layouts.app')

@section('header')
    @include('components.page-hero', [
        'heroVariant' => 'split',
        'heroTitle'   => $page->long_title,
        'heroEyebrow' => $page->subtitle,
        'heroIntro'   => $page->summary,
        'heroMedia'   => $page->header,
    ])
@endsection

@section('content')
    <section class="py-24 2xl:py-32 bg-white">
        <div class="max-w-6xl mx-auto relative z-10 grid xl:grid-cols-[2fr_1fr] gap-12 xl:gap-16">
            @include('form-pages.partials.form-panel')

            <div class="relative">
                <div class="sticky top-36 flex flex-col gap-4">
                    <div class="bg-blue-light-200 p-8 xl:p-12 rounded-4xl">
                        <div class="page-content">
                            <h2 class="!text-xl !font-bold uppercase text-black">{{ $company->name() }}</h2>
                            <p>{{ $company->street() }}<br/>{{ $company->postcode() }} {{ $company->city() }}<br/>{{ $company->country() }}</p>
                            <p>
                                <i class="fa-solid fa-phone text-blue mr-2" aria-hidden="true"></i><a href="{{ $company->phoneHref() }}">{{ $company->phone() }}</a><br/>
                                <i class="fa-solid fa-envelope text-blue mr-2" aria-hidden="true"></i><a href="mailto:{{ $company->email() }}">{{ $company->email() }}</a>
                            </p>
                            @if($company->openingHours())
                                <p class="!mb-0"><strong>Openingstijden</strong><br/>{{ $company->openingHours() }}</p>
                            @endif
                        </div>
                    </div>
                    <nav aria-label="Direct regelen" class="flex flex-col">
                        @foreach(array_filter([
                            $quotePage ? ['Offerte aanvragen', 'fa-solid fa-file-lines', $quotePage->url] : null,
                            $orderPage ? ['Gas bestellen', 'fa-solid fa-fire', $orderPage->url] : null,
                            $company->portalUrl() ? ['Mijn Robogas', 'fa-solid fa-user', $company->portalUrl()] : null,
                        ]) as [$quickLabel, $quickIcon, $quickUrl])
                            <a href="{{ $quickUrl }}" class="group flex items-center gap-4 py-4 px-2 border-b border-blue-light-300 font-heading font-bold text-black hover:text-blue transition-colors duration-300">
                                <i class="{{ $quickIcon }} text-blue w-5" aria-hidden="true"></i>
                                <span class="grow">{{ $quickLabel }}</span>
                                <i class="fa-regular fa-angle-right text-blue transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true"></i>
                            </a>
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>
    </section>

    @if($company->mapsEmbedUrl())
        <section class="pb-24 2xl:pb-32 bg-white">
            <div class="max-w-7xl mx-auto relative z-10">
                <iframe src="{{ $company->mapsEmbedUrl() }}" title="Kaart: {{ $company->street() }}, {{ $company->city() }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        class="block w-full h-104 rounded-4xl border-0 bg-blue-light-200"></iframe>
            </div>
        </section>
    @endif

    @include('components.faq-accordion')
@endsection
