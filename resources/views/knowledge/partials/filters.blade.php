{{--
    Themafilters in de header van Onze kennis. Filteren gebeurt in de browser;
    zie resources/js/knowledge.js.

    @var Collection<ArticleTheme> $themes  @uses geërfde scope van de view
--}}
@if($themes->count() > 1)
    <div class="flex flex-wrap gap-x-6 gap-y-3 mt-6" role="group" aria-label="Filter op thema" data-knowledge-filters>
        <button type="button" class="font-heading text-base pb-1.5 border-b-2 transition-colors duration-300 hover:text-yellow text-yellow font-extrabold border-yellow" aria-pressed="true" data-knowledge-filter="">Alle thema's</button>
        @foreach($themes as $filterTheme)
            <button type="button" class="font-heading text-base pb-1.5 border-b-2 transition-colors duration-300 text-white font-medium border-transparent hover:text-yellow" aria-pressed="false" data-knowledge-filter="{{ $filterTheme->id }}">{{ $filterTheme->title }}</button>
        @endforeach
    </div>
@endif
