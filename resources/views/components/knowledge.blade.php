{{--
    Homepage: de eerste kennisartikelen, met een link naar Onze kennis.

    @var Collection<Article> $homeArticles   @uses HomeArticlesComposer
    @var Page|null           $knowledgePage  @uses HomeArticlesComposer
--}}
@if($homeArticles->isNotEmpty())
    <section class="pt-24 2xl:pt-32 relative">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="mb-12 text-center">
                <h2 class="text-5xl">{{ $knowledgePage?->title ?? 'Onze kennis' }}</h2>
                <span class="block font-heading font-bold uppercase text-blue">Andere vraag? Wij beantwoorden hem!</span>
            </div>
            @include('components.knowledge-grid', ['gridArticles' => $homeArticles])
            @if($knowledgePage)
                <div class="text-center mt-12">
                    <a href="{{ $knowledgePage->url }}" class="btn btn-primary">Bekijk alle vragen</a>
                </div>
            @endif
        </div>
        <div class="bg-blue-light-200 w-full sm:w-[calc(100%-64px)] h-44 absolute left-0 bottom-0 z-1 sm:mx-8 rounded-t-4xl"></div>
    </section>
@endif
