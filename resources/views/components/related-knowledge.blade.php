{{--
    Drie kennisartikelen op een lichtblauwe ondergrond. Uit het ontwerp:
    RelatedKnowledge. Zonder artikelen rendert hij niets.

    @var Collection<int, Article> $relatedArticles  @uses meegegeven bij @include
    @var string|null              $relatedTitle     standaard "Verder lezen"  @uses meegegeven bij @include
--}}
@if($relatedArticles->isNotEmpty())
    <section class="py-24 2xl:py-32 relative">
        <div class="w-full sm:w-[calc(100%-64px)] h-3/5 absolute left-0 bottom-0 z-1 sm:mx-8 rounded-t-4xl bg-blue-light-200"></div>
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="mb-12">
                @include('components.section-heading', [
                    'headingTitle'   => $relatedTitle ?? 'Verder lezen',
                    'headingEyebrow' => 'Andere vraag? Wij beantwoorden hem!',
                    'headingAlign'   => 'center',
                ])
            </div>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach($relatedArticles as $relatedArticle)
                    @include('components.knowledge-card', ['knowledgeArticle' => $relatedArticle, 'knowledgeDome' => true, 'knowledgeHeight' => 'h-80 md:h-[360px]'])
                @endforeach
            </div>
        </div>
    </section>
@endif
