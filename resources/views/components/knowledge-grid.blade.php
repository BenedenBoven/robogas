{{--
    Kennisartikelen in drie kolommen, met de bovenste kaart van elke kolom in
    koepelvorm en afwisselende hoogtes. Zonder JavaScript verdeelt de server de
    kaarten; resources/js/knowledge.js verdeelt ze opnieuw na filteren en op
    smallere schermen, zodat de koepel altijd bovenaan een kolom staat.

    @var Collection<Article> $gridArticles  @uses meegegeven bij @include
    @var string|null         $gridHeadingTag  kopniveau van de kaarten  @uses meegegeven bij @include
--}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 items-start" data-knowledge-grid>
    @for($gridColumn = 0; $gridColumn < 3; $gridColumn++)
        <div class="flex flex-col gap-4" data-knowledge-column>
            @foreach($gridArticles->values()->filter(fn($article, $index) => $index % 3 === $gridColumn)->values() as $gridIndex => $gridArticle)
                <div data-knowledge-item data-theme="{{ $gridArticle->article_theme_id }}">
                    @include('components.knowledge-card', [
                        'knowledgeArticle' => $gridArticle,
                        'knowledgeDome'    => $gridIndex === 0,
                        'knowledgeHeight'  => $gridIndex % 2 === $gridColumn % 2 ? 'h-80 md:h-[400px]' : 'h-72 md:h-[320px]',
                        'knowledgeTag'     => $gridHeadingTag ?? 'h3',
                    ])
                </div>
            @endforeach
        </div>
    @endfor
</div>
