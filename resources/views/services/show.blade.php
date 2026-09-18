{{--
    Dienst — detail: één stap uit de A-tot-Z aanpak. Het stappenlint staat in de
    header; eronder de inhoud met een zijbalk voor wat we van de klant nodig hebben.

    @var Taxonomy            $taxonomy      @uses ShowService
    @var Service             $service       @uses ShowService
    @var Collection<Service> $services      @uses ShowService
    @var int|null            $stepNumber    @uses ShowService
    @var Service|null        $previousStep  @uses ShowService
    @var Service|null        $nextStep      @uses ShowService
    @var Page|null           $quotePage     @uses QuotePage
    @var Page|null           $contactPage   @uses ContactPage
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
        'heroAppend'    => 'services.partials.hero-steps',
    ])
@endsection

@section('content')
    <section class="pt-24 2xl:pt-32 pb-16 bg-white">
        <div class="max-w-6xl mx-auto relative z-10 grid xl:grid-cols-[2fr_1fr] gap-12 xl:gap-16 items-start">
            <div class="flex flex-col gap-12">
                @if($service->body)
                    {!! editable($service, 'body', 'div', 'page-content max-w-[70ch]') !!}
                @endif

                @if($service->we_do_items)
                    <div>
                        <h2 class="text-3xl lg:text-4xl font-extrabold text-black mb-6">
                            <i class="{{ $service->icon_class }} text-blue mr-2" aria-hidden="true"></i>Wat wij doen
                        </h2>
                        <ul class="grid sm:grid-cols-2 gap-4">
                            @foreach($service->we_do_items as $weDoItem)
                                <li class="flex gap-4 items-start bg-grey rounded-3xl p-6">
                                    <span class="shrink-0 size-8 rounded-full bg-blue text-white flex items-center justify-center text-sm" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
                                    <span class="font-heading font-bold text-black leading-snug pt-1">{{ $weDoItem }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($service->audiences->isNotEmpty())
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="font-heading font-bold uppercase text-sm text-blue mr-2">Relevant voor</span>
                        @foreach($service->audiences as $relevantAudience)
                            @include('components.audience-label', ['labelAudience' => $relevantAudience, 'labelLink' => true])
                        @endforeach
                    </div>
                @endif
            </div>

            <aside class="xl:sticky xl:top-36 flex flex-col gap-4">
                @if($service->we_need_items)
                    <div class="bg-blue-light-200 rounded-4xl p-8 xl:p-10">
                        <h2 class="text-2xl font-extrabold text-black">
                            <i class="fa-solid fa-clipboard-list text-blue mr-2" aria-hidden="true"></i>Wat we van jou nodig hebben
                        </h2>
                        <div class="page-content mt-4">
                            <ul class="!mb-0">
                                @foreach($service->we_need_items as $weNeedItem)
                                    <li>{{ $weNeedItem }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @if($quotePage || $contactPage)
                    <div class="bg-black rounded-4xl p-8 xl:p-10 flex flex-col gap-2">
                        <span class="font-heading font-extrabold text-2xl text-white leading-tight">Zullen we het doorrekenen?</span>
                        <span class="font-heading font-bold uppercase text-sm text-yellow">Een prijs op maat</span>
                        <div class="flex flex-wrap gap-3 mt-4">
                            @if($quotePage)
                                <a href="{{ $quotePage->url }}" class="btn btn-primary">Offerte aanvragen</a>
                            @endif
                            @if($contactPage)
                                <a href="{{ $contactPage->url }}" class="btn btn-trans">Stel je vraag</a>
                            @endif
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </section>

    @include('components.image-band', ['bandMedia' => $service->header, 'bandHeight' => 'h-80 lg:h-104'])

    @include('components.prev-next')
@endsection
