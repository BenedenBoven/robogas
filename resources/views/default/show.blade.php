{{--
    Standaardpagina: juridische teksten en losse pagina's uit het beheer. Uit
    het ontwerp: de tekstpagina met zijbalk (ContentScreen), die het ontwerp
    "het CMS-sjabloon voor losse pagina's" noemt.

    Met een headerbeeld wordt het een gesplitste header, zonder een lichtblauwe
    band; een juridische tekst heeft geen foto nodig.

    @var Taxonomy       $taxonomy     @uses ShowDefault
    @var Page           $page         @uses ShowDefault
    @var Page|null      $contactPage  @uses ContactPage
    @var CompanyDetails $company      @uses CompanyDetailsComposer
--}}
@extends('layouts.app')

@php
    $defaultImages = $page instanceof \App\Domains\Page\Models\Page ? $page->images : collect();
    $defaultHeader = $page->header ?? null;
@endphp

@section('header')
    @include('components.page-hero', [
        'heroVariant' => $defaultHeader ? 'split' : 'band',
        'heroTitle'   => $page->long_title ?? $page->title,
        'heroEyebrow' => $page->subtitle ?? null,
        'heroIntro'   => $page->summary ?? null,
        'heroMedia'   => $defaultHeader,
    ])
@endsection

@section('content')
    <section class="py-24 2xl:py-32 bg-white">
        <div class="max-w-6xl mx-auto relative z-10 grid xl:grid-cols-[2fr_1fr] gap-12 xl:gap-16 items-start">
            <div class="flex flex-col gap-12">
                {!! editable($page, 'body', 'div', 'page-content max-w-[70ch] [&>p:first-child]:text-lg') !!}

                @if($defaultImages->isNotEmpty())
                    {{-- Bij een oneven aantal pakt de laatste foto de volle breedte, anders staat hij los. --}}
                    <div class="gallery grid sm:grid-cols-2 gap-4 sm:[&>figure:last-child:nth-child(odd)]:col-span-2">
                        @foreach($defaultImages as $defaultImage)
                            <figure>
                                <a href="{{ $defaultImage->lg }}" data-src="{{ $defaultImage->lg }}" data-thumb="{{ $defaultImage->xs }}" class="block">
                                    @include('components.media-img', ['media' => $defaultImage, 'format' => 'md', 'class' => 'w-full h-72 object-cover rounded-3xl'])
                                </a>
                            </figure>
                        @endforeach
                    </div>
                @endif
            </div>
            @include('components.aside-card', [
                'asideTitle'    => 'Vragen?',
                'asideBody'     => 'Bel ons op ' . $company->phone() . ' of stuur een bericht. Je krijgt iemand uit Nijkerk aan de lijn.',
                'asideCtaLabel' => $contactPage ? 'Contact opnemen' : null,
                'asideCtaUrl'   => $contactPage?->url,
            ])
        </div>
    </section>
@endsection
