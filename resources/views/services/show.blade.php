{{--
    Dienst — detail: één stap uit de A-tot-Z aanpak, met zijn plek in het geheel.

    @var Taxonomy            $taxonomy      @uses ShowService
    @var Service             $service       @uses ShowService
    @var Collection<Service> $services      @uses ShowService
    @var int|null            $stepNumber    @uses ShowService
    @var Service|null        $previousStep  @uses ShowService
    @var Service|null        $nextStep      @uses ShowService
--}}
@extends('layouts.app')

@php $stepLabel = $stepNumber ? str_pad((string)$stepNumber, 2, '0', STR_PAD_LEFT) : null; @endphp

@section('header')
    @include('components.page-hero', [
        'heroVariant'   => 'band',
        'heroTitle'     => $service->title,
        'heroEyebrow'   => $stepLabel ? 'Stap ' . $stepLabel . ' van ' . $services->count() : null,
        'heroIntro'     => $service->summary,
        'heroWatermark' => $stepLabel,
    ])
@endsection

@section('content')
    @if($service->body)
        <section class="pt-24 2xl:pt-32 bg-white">
            <div class="max-w-6xl mx-auto relative z-10">
                {!! editable($service, 'body', 'div', 'page-content max-w-[70ch]') !!}
            </div>
        </section>
    @endif

    @include('components.fact-panels', ['factGroups' => [
        ['title' => 'Wat wij doen', 'icon' => $service->icon_class, 'items' => $service->we_do_items],
        ['title' => 'Wat we van jou nodig hebben', 'icon' => 'fa-solid fa-clipboard-list', 'tone' => 'brand', 'items' => $service->we_need_items],
    ]])

    @include('components.image-band', ['bandMedia' => $service->header, 'bandHeight' => 'h-80 lg:h-104'])

    @include('components.step-ribbon', [
        'ribbonActive'  => $service,
        'ribbonTone'    => 'tint',
        'ribbonTitle'   => 'Waar deze stap in het geheel zit',
        'ribbonEyebrow' => 'Onze A-tot-Z aanpak',
    ])

    @include('components.prev-next')
@endsection
