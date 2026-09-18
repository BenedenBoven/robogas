{{--
    Onze kennis — overzicht: alle kennisartikelen, te filteren op thema.

    @var Taxonomy                 $taxonomy     @uses ListArticles
    @var Page                     $page         @uses ListArticles
    @var Collection<Article>      $articles     @uses ListArticles
    @var Collection<ArticleTheme> $themes       @uses ListArticles
    @var Page|null                $faqPage      @uses FaqPage
    @var Page|null                $contactPage  @uses ContactPage
--}}
@extends('layouts.app')

@section('header')
    @include('components.page-hero', [
        'heroVariant' => 'band',
        'heroTitle'   => $page->long_title,
        'heroEyebrow' => $page->subtitle,
        'heroIntro'   => $page->summary,
        'heroAppend'  => 'knowledge.partials.filters',
    ])
@endsection

@section('content')
    <section class="py-24 2xl:py-32 bg-white">
        <div class="max-w-7xl mx-auto relative z-10">
            @include('components.knowledge-grid', ['gridArticles' => $articles, 'gridHeadingTag' => 'h2'])
            <p class="hidden mt-8 text-grey-500" data-knowledge-empty>Nog geen artikelen in dit thema. Bel ons gerust, dan beantwoorden we je vraag persoonlijk.</p>
        </div>
    </section>

    @if($page->block_title)
        <section class="pb-24 2xl:pb-32 bg-white">
            <div class="max-w-6xl mx-auto relative z-10">
                @include('components.cta-block', [
                    'ctaTone'    => 'tint',
                    'ctaAlign'   => 'center',
                    'ctaTitle'   => $page->block_title,
                    'ctaEyebrow' => $page->block_subtitle,
                    'ctaActions' => array_values(array_filter([
                        $faqPage ? ['label' => $faqPage->title, 'url' => $faqPage->url, 'variant' => 'dark'] : null,
                        $contactPage ? ['label' => 'Contact opnemen', 'url' => $contactPage->url, 'variant' => 'primary'] : null,
                    ])),
                ])
            </div>
        </section>
    @endif
@endsection
