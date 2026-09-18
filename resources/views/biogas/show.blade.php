{{--
    Biogas — tekstpagina met zijbalk en een vergelijking. Uit het ontwerp:
    BiogasScreen. De vergelijkingstabel staat in de tekst zelf (editor), zodat
    de redactie hem kan aanpassen; de opmaak komt uit .page-content table.

    @var Taxonomy                 $taxonomy     @uses ShowBiogas
    @var Page                     $page         @uses ShowBiogas
    @var Collection<int, Article> $related      @uses ShowBiogas
    @var Page|null                $contactPage  @uses ContactPage
    @var Page|null                $quotePage    @uses QuotePage
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
        <div class="max-w-6xl mx-auto relative z-10 grid xl:grid-cols-[2fr_1fr] gap-12 xl:gap-16 items-start">
            <div class="flex flex-col gap-12">
                @if($page->body)
                    {!! editable($page, 'body', 'div', 'page-content max-w-[70ch] [&>h2:first-child]:text-4xl [&>h2:first-child]:font-extrabold [&>h2:first-child]:mt-0 [&>h2+p]:text-lg') !!}
                @endif

                @if($page->block_title)
                    @include('components.cta-block', [
                        'ctaTone'    => 'accent',
                        'ctaTitle'   => $page->block_title,
                        'ctaEyebrow' => $page->block_subtitle,
                        'ctaBody'    => $page->block_content ? trim(html_entity_decode(strip_tags($page->block_content))) : null,
                        'ctaActions' => array_values(array_filter([
                            $quotePage ? ['label' => 'Advies aanvragen', 'url' => $quotePage->url, 'variant' => 'dark'] : null,
                            $contactPage ? ['label' => 'Contact opnemen', 'url' => $contactPage->url, 'variant' => 'secondary'] : null,
                        ])),
                    ])
                @endif
            </div>
            @include('components.aside-card', [
                'asideTitle'    => 'Is biopropaan iets voor jou?',
                'asideBody'     => 'Vertel ons wat je stookt en hoeveel. Wij zeggen eerlijk of het kan en wat het kost.',
                'asideCtaLabel' => $quotePage ? 'Advies aanvragen' : null,
                'asideCtaUrl'   => $quotePage?->url,
            ])
        </div>
    </section>

    @include('components.related-knowledge', ['relatedArticles' => $related])
@endsection
