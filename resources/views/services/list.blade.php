{{--
    Diensten — overzicht: de A-tot-Z aanpak als stappenpad.

    @var Taxonomy            $taxonomy     @uses ListServices
    @var Page                $page         @uses ListServices
    @var Collection<Service> $services     @uses ListServices
    @var Collection<Audience> $audiences   @uses ListServices
    @var Page|null           $contactPage  @uses ContactPage
    @var Page|null           $quotePage    @uses QuotePage
--}}
@extends('layouts.app')

@section('header')
    @include('components.page-hero', [
        'heroVariant' => 'split',
        'heroTitle'   => $page->long_title,
        'heroEyebrow' => $page->subtitle,
        'heroIntro'   => $page->summary,
        'heroMedia'   => $page->header,
        'heroAppend'  => 'services.partials.hero-buttons',
    ])
@endsection

@section('content')
    @include('components.step-path')

    @if($page->block_title || $page->block_content)
        <section class="py-24 2xl:py-32 bg-blue-light-200">
            <div class="max-w-6xl mx-auto relative z-10 grid xl:grid-cols-[1fr_2fr] gap-12 xl:gap-16 items-center">
                <div>
                    @include('components.section-heading', [
                        'headingTitle'   => $page->block_title,
                        'headingEyebrow' => $page->block_subtitle,
                        'headingSize'    => 'text-3xl lg:text-4xl',
                    ])
                    @if($page->block_content)
                        {!! editable($page, 'block_content', 'div', 'page-content mt-4') !!}
                    @endif
                    @if($contactPage)
                        <a href="{{ $contactPage->url }}" class="btn btn-dark mt-4">Stel je vraag</a>
                    @endif
                </div>
                @if($audiences->isNotEmpty())
                    <div class="flex flex-wrap justify-between gap-8">
                        @foreach($audiences as $blockAudience)
                            @include('components.audience-icon', ['iconAudience' => $blockAudience, 'iconGround' => 'white'])
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    @endif

    @if($quotePage || $contactPage)
        <section class="py-24 2xl:py-32">
            <div class="max-w-6xl mx-auto relative z-10">
                @include('components.cta-block', [
                    'ctaTone'    => 'dark',
                    'ctaAlign'   => 'center',
                    'ctaTitle'   => 'Zullen we het doorrekenen?',
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
