{{--
    Over ons — het merkverhaal. Uit het ontwerp: AboutScreen. Foto-header,
    tekst met zijbalk, kerncijfers, tijdlijn, beeldband en een CTA.

    Kerncijfers en mijlpalen komen uit hun eigen tabbladen (StepList), de kop
    boven de tijdlijn uit de blokvelden.

    @var Taxonomy       $taxonomy     @uses ShowAbout
    @var Page           $page         @uses ShowAbout
    @var Page|null      $contactPage  @uses ContactPage
    @var Page|null      $quotePage    @uses QuotePage
--}}
@extends('layouts.app')

@section('header')
    @include('components.page-hero', [
        'heroVariant' => 'photo',
        'heroTitle'   => $page->long_title,
        'heroEyebrow' => $page->subtitle,
        'heroIntro'   => $page->summary,
        'heroMedia'   => $page->header,
    ])
@endsection

@section('content')
    @if($page->body)
        <section class="py-24 2xl:py-32 bg-white">
            <div class="max-w-6xl mx-auto relative z-10 grid xl:grid-cols-[2fr_1fr] gap-12 xl:gap-16 items-start">
                {!! editable($page, 'body', 'div', 'page-content max-w-[70ch] [&>h2:first-child]:text-4xl [&>h2:first-child]:font-extrabold [&>h2:first-child]:mt-0 [&>h2+p]:text-lg') !!}
                @include('components.aside-card', [
                    'asideTitle'    => 'Liever even bellen?',
                    'asideBody'     => 'Je krijgt iemand uit Nijkerk aan de lijn die je installatie kent.',
                    'asideCtaLabel' => $contactPage ? 'Contact opnemen' : null,
                    'asideCtaUrl'   => $contactPage?->url,
                ])
            </div>
        </section>
    @endif

    @include('components.stat-strip', ['statItems' => $page->facts])

    @include('components.timeline', [
        'timelineItems'   => $page->milestones,
        'timelineTitle'   => $page->block_title,
        'timelineEyebrow' => $page->block_subtitle,
        'timelineIntro'   => $page->block_content,
    ])

    @include('components.image-band', ['bandMedia' => $page->images->first(), 'bandHeight' => 'h-80 lg:h-120'])

    @if($quotePage || $contactPage)
        <section class="pb-24 2xl:pb-32 bg-white">
            <div class="max-w-6xl mx-auto relative z-10">
                @include('components.cta-block', [
                    'ctaTone'    => 'dark',
                    'ctaAlign'   => 'center',
                    'ctaTitle'   => 'Benieuwd wat het kost?',
                    'ctaEyebrow' => 'Binnen twee werkdagen een prijs op maat',
                    'ctaActions' => array_values(array_filter([
                        $quotePage ? ['label' => 'Offerte aanvragen', 'url' => $quotePage->url] : null,
                        $contactPage ? ['label' => 'Contact opnemen', 'url' => $contactPage->url, 'variant' => 'trans'] : null,
                    ])),
                ])
            </div>
        </section>
    @endif
@endsection
