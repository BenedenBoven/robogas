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
        <div class="max-w-6xl mx-auto relative z-10 grid lg:grid-cols-2 gap-8">
            @foreach($audiences as $cardAudience)
                @php $cardTint = $loop->index % 2 === 1; @endphp
                <div @class([
                    'relative rounded-3xl p-8 xl:p-10 flex flex-col sm:flex-row gap-6 xl:gap-8 group hover:shadow-xl hover:-translate-y-2 duration-300 transition-all',
                    'bg-blue-light-200 border border-blue-light-200' => $cardTint,
                    'bg-white border border-blue-light-300' => !$cardTint,
                ])>
                    <a href="{{ $cardAudience->url }}" class="absolute inset-0 z-20" aria-label="{{ $cardAudience->title }}"></a>
                    <div @class(['shrink-0 size-24 rounded-full p-5', 'bg-white' => $cardTint, 'bg-blue-light-200' => !$cardTint])>
                        <img src="{{ Vite::asset($cardAudience->icon_asset) }}" alt="" class="w-full h-full object-contain"/>
                    </div>
                    <div class="flex flex-col gap-3">
                        <h2 class="font-light text-4xl text-black">{{ $cardAudience->title }}</h2>
                        @if($cardAudience->summary)
                            <p>{{ $cardAudience->summary }}</p>
                        @endif
                        @if($cardAudience->use_items)
                            <div class="flex flex-wrap gap-2">
                                @foreach($cardAudience->use_items as $cardUse)
                                    <span class="inline-block bg-yellow text-black text-sm font-bold px-3 py-2 font-heading">{{ $cardUse }}</span>
                                @endforeach
                            </div>
                        @endif
                        <span class="btn btn-dark group-hover:btn-active mt-4">Bekijk</span>
                    </div>
                </div>
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
