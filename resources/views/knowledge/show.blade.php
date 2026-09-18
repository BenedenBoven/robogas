{{--
    Kennisartikel — detail: leeskolom met zijbalk en gerelateerde artikelen.

    @var Taxonomy            $taxonomy     @uses ShowArticle
    @var Article             $article      @uses ShowArticle
    @var Collection<Article> $related      @uses ShowArticle
    @var Page|null           $quotePage    @uses QuotePage
    @var Page|null           $contactPage  @uses ContactPage
--}}
@extends('layouts.app')

@section('header')
    @include('components.page-hero', [
        'heroVariant' => 'split',
        'heroTitle'   => $article->title,
        'heroEyebrow' => $article->theme?->title,
        'heroIntro'   => $article->summary,
        'heroMedia'   => $article->header,
        'heroAppend'  => 'knowledge.partials.tags',
    ])
@endsection

@section('content')
    <section class="py-24 2xl:py-32 bg-white">
        <div class="max-w-6xl mx-auto relative z-10 grid xl:grid-cols-[2fr_1fr] gap-12 xl:gap-16 items-start">
            <div>
                @if($article->body)
                    {!! editable($article, 'body', 'div', 'page-content max-w-[72ch]') !!}
                @endif
            </div>
            @if($quotePage || $contactPage)
                <aside class="xl:sticky xl:top-36 bg-blue-light-200 p-8 xl:p-12 rounded-4xl">
                    <h2 class="text-xl font-bold uppercase text-black">Zelf aan de slag?</h2>
                    <p class="mt-3 mb-5">Vraag een offerte aan of bel ons. We rekenen je situatie graag door.</p>
                    <div class="flex flex-wrap gap-3">
                        @if($quotePage)
                            <a href="{{ $quotePage->url }}" class="btn btn-dark">Offerte aanvragen</a>
                        @endif
                        @if($contactPage)
                            <a href="{{ $contactPage->url }}" class="btn btn-primary">Contact</a>
                        @endif
                    </div>
                </aside>
            @endif
        </div>
    </section>

    @include('components.related-knowledge', ['relatedArticles' => $related])
@endsection
