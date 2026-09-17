{{--
    Doelgroep — detail: voordelen, toepassingen, wat we doen en hoe we het aanpakken.

    @var Taxonomy            $taxonomy   @uses ShowAudience
    @var Audience            $audience   @uses ShowAudience
    @var Collection<Service> $services   @uses ShowAudience
    @var Page|null           $quotePage  @uses QuotePage
    @var Page|null           $orderPage  @uses OrderPage
--}}
@extends('layouts.app')

@php $audienceImage = $audience->images->first(); @endphp

@section('header')
    @include('components.page-hero', [
        'heroVariant' => 'split',
        'heroTitle'   => $audience->long_title,
        'heroEyebrow' => $audience->title,
        'heroIntro'   => $audience->summary,
        'heroMedia'   => $audience->header,
    ])
@endsection

@section('content')
    @include('components.fact-panels', ['factGroups' => [
        ['title' => 'Voordelen', 'icon' => 'fa-solid fa-circle-check', 'items' => $audience->benefit_items],
        ['title' => 'Toepassingen', 'icon' => 'fa-solid fa-fire', 'tone' => 'brand', 'items' => $audience->use_items],
    ]])

    @if($audience->body)
        <section class="pb-24 2xl:pb-32 bg-white">
            <div @class(['max-w-6xl mx-auto relative z-10 grid gap-12 xl:gap-16 items-start', 'lg:grid-cols-[3fr_2fr]' => $audienceImage])>
                <div>
                    <h2 class="text-3xl lg:text-4xl font-extrabold mb-5">Wat wij doen voor {{ Str::lower($audience->title) }}</h2>
                    {!! editable($audience, 'body', 'div', 'page-content max-w-[70ch]') !!}
                </div>
                @if($audienceImage)
                    @include('components.media-img', [
                        'media'  => $audienceImage,
                        'format' => 'md',
                        'class'  => 'block w-full h-72 lg:h-96 object-cover rounded-t-4xl rounded-bl-4xl',
                    ])
                @endif
            </div>
        </section>
    @endif

    <section class="pb-24 2xl:pb-32 bg-white">
        <div class="max-w-6xl mx-auto relative z-10">
            @include('components.action-panel', [
                'panelTitle'   => $audience->long_title . ' regelen?',
                'panelBody'    => 'Vertel ons wat je stookt en hoeveel, dan maken we een prijs op maat.',
                'panelActions' => array_values(array_filter([
                    $quotePage ? ['label' => 'Offerte aanvragen', 'url' => $quotePage->url] : null,
                    $orderPage ? ['label' => 'Gas bestellen', 'url' => $orderPage->url, 'icon' => 'fa-solid fa-fire'] : null,
                ])),
            ])
        </div>
    </section>

    @include('components.step-ribbon', [
        'ribbonActive'  => null,
        'ribbonTone'    => 'tint',
        'ribbonTitle'   => 'Hoe we het aanpakken',
        'ribbonEyebrow' => 'Van advies tot bijvullen',
        'ribbonClose'   => true,
    ])
@endsection
