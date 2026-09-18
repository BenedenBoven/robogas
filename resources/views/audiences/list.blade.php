{{--
    Doelgroepen — overzicht: grote keuzekaarten per doelgroep.

    @var Taxonomy             $taxonomy     @uses ListAudiences
    @var Page                 $page         @uses ListAudiences
    @var Collection<Audience> $audiences    @uses ListAudiences
    @var Page|null            $contactPage  @uses ContactPage
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
    <section class="py-24 2xl:py-32 bg-white">
        <div class="max-w-6xl mx-auto relative z-10 grid md:grid-cols-2 xl:grid-cols-3 gap-8">
            @foreach($audiences as $cardAudience)
                <article class="relative bg-blue-light-200 hover:bg-blue-light-300 rounded-3xl p-3 hover:-translate-y-2 duration-300 transition-all flex flex-col group overflow-hidden">
                    <a href="{{ $cardAudience->url }}" class="absolute inset-0 z-30" aria-label="{{ $cardAudience->title }}"></a>
                    <div class="relative z-10 h-64 overflow-hidden rounded-2xl">
                        @include('components.media-img', [
                            'media'  => $cardAudience->header,
                            'format' => 'sm',
                            'class'  => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105',
                        ])
                    </div>
                    <div class="relative z-10 -mt-10 ml-6 size-20 rounded-full bg-white p-4 ring-6 ring-blue-light-200 group-hover:ring-blue-light-300 transition-all duration-300">
                        <img src="{{ Vite::asset($cardAudience->icon_asset) }}" alt="" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-110"/>
                    </div>
                    <div class="relative z-10 px-6 pb-6 pt-4 flex flex-col gap-3 grow">
                        <h2 class="font-light text-3xl text-black">{{ $cardAudience->title }}</h2>
                        @if($cardAudience->summary)
                            <p>{{ $cardAudience->summary }}</p>
                        @endif
                        <span class="mt-auto pt-2 font-heading font-bold text-blue">
                            Bekijk <i class="fa-regular fa-arrow-right ml-1 inline-block transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="absolute h-2/3 w-full bottom-0 right-0 z-1 overflow-hidden pointer-events-none" aria-hidden="true">
                        <svg class="h-full w-auto ml-auto translate-x-1/4" viewBox="0 0 28.9 51.7">
                            <path class="fill-white/40 transition-all duration-900 group-hover:fill-white/60" d="M14.3,0L4.1,10.2c-5.5,5.5-5.5,14.4,0,20l10.2-10.2c5.5-5.5,5.5-14.4,0-20"/>
                            <path class="fill-white/40 transition-all duration-900 group-hover:fill-white/60" d="M9.5,51.7l15.2-15.2c5.5-5.5,5.5-14.4,0-20l-15.2,15.2c-5.5,5.5-5.5,14.4,0,20"/>
                        </svg>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    @include('components.image-band', ['bandMedia' => $page->images->first(), 'bandHeight' => 'h-72 lg:h-96'])

    @if($page->block_title)
        <section class="pb-24 2xl:pb-32 bg-white">
            <div class="max-w-6xl mx-auto relative z-10">
                @include('components.cta-block', [
                    'ctaTone'    => 'tint',
                    'ctaTitle'   => $page->block_title,
                    'ctaEyebrow' => $page->block_subtitle,
                    'ctaBody'    => $page->block_content ? strip_tags($page->block_content) : null,
                    'ctaActions' => $contactPage ? [['label' => 'Contact opnemen', 'url' => $contactPage->url]] : [],
                ])
            </div>
        </section>
    @endif
@endsection
