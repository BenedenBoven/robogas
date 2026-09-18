{{--
    Vacatures: werken bij RoboGas, met de lijst open vacatures.

    @var Taxonomy            $taxonomy     @uses ListVacancies
    @var Page                $page         @uses ListVacancies
    @var Collection<Vacancy> $vacancies    @uses ListVacancies
    @var Page|null           $contactPage  @uses ContactPage
    @var CompanyDetails      $company      @uses CompanyDetailsComposer
--}}
@extends('layouts.app')

@php
    // De kicker telt vanzelf mee, tenzij de redactie er zelf een invult.
    $vacancyCount = $vacancies->count();
    $vacancyKicker = $page->subtitle ?: match (true) {
        $vacancyCount === 0 => 'Op dit moment geen open vacatures',
        $vacancyCount === 1 => 'Eén open vacature',
        default             => $vacancyCount . ' open vacatures',
    };
@endphp

@section('header')
    @include('components.page-hero', [
        'heroVariant' => 'split',
        'heroTitle'   => $page->long_title,
        'heroEyebrow' => $vacancyKicker,
        'heroIntro'   => $page->summary,
        'heroMedia'   => $page->header,
    ])
@endsection

@section('content')
    <section class="py-24 2xl:py-32 bg-white">
        <div class="max-w-6xl mx-auto relative z-10 grid xl:grid-cols-[2fr_1fr] gap-12 xl:gap-16 items-start">
            <div class="flex flex-col gap-12">
                @if($page->body)
                    {!! editable($page, 'body', 'div', 'page-content max-w-[70ch] [&>p:first-child]:text-lg') !!}
                @endif

                <div class="flex flex-col gap-3">
                    <h2 class="text-3xl font-extrabold text-black mb-2">Open vacatures</h2>
                    @forelse($vacancies as $listVacancy)
                        <a href="{{ $listVacancy->url }}" class="group flex items-center justify-between gap-6 bg-blue-light-200 rounded-3xl px-8 py-6 transition-shadow duration-200 hover:shadow-[inset_4px_0_0_var(--color-blue)]">
                            <span>
                                <span class="block font-heading font-extrabold text-2xl text-black">{{ $listVacancy->title }}</span>
                                @if($listVacancy->meta)
                                    <span class="block text-sm text-black mt-1">{{ $listVacancy->meta }}</span>
                                @endif
                            </span>
                            <i class="fa-regular fa-angle-right text-2xl text-blue transition-transform duration-200 group-hover:translate-x-1" aria-hidden="true"></i>
                        </a>
                    @empty
                        <p>Op dit moment hebben we geen open vacatures. Een open sollicitatie is altijd welkom.</p>
                    @endforelse
                </div>

                @if($page->images->count() >= 2)
                    <div class="grid sm:grid-cols-2 gap-4">
                        @foreach($page->images->take(2) as $vacancyImage)
                            @include('components.media-img', ['media' => $vacancyImage, 'format' => 'md', 'class' => 'w-full h-72 object-cover rounded-md'])
                        @endforeach
                    </div>
                @endif

                @if($page->block_title && $contactPage)
                    @include('components.cta-block', [
                        'ctaTone'    => 'accent',
                        'ctaTitle'   => $page->block_title,
                        'ctaEyebrow' => $page->block_subtitle,
                        'ctaActions' => [['label' => 'Contact opnemen', 'url' => $contactPage->url, 'variant' => 'dark']],
                    ])
                @endif
            </div>

            <aside class="xl:sticky xl:top-36 bg-blue-light-200 p-8 xl:p-12 rounded-4xl">
                <h2 class="text-xl font-bold uppercase text-black">Vragen over een vacature?</h2>
                <p class="mt-3 mb-5">Bel ons en vraag naar de binnendienst. Die plant meteen een kennismaking in.</p>
                <a href="{{ $company->phoneHref() }}" class="btn btn-primary">Bel {{ $company->phone() }}</a>
            </aside>
        </div>
    </section>
@endsection
