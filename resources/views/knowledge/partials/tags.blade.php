{{--
    De doelgroepen van een artikel als labels in de header, met een link naar de doelgroep.

    @var Article $article  @uses geërfde scope van de view
--}}
@if($article->audiences->isNotEmpty())
    <div class="flex flex-wrap gap-2 mt-2">
        @foreach($article->audiences as $tagAudience)
            @include('components.audience-label', ['labelAudience' => $tagAudience, 'labelLink' => true])
        @endforeach
    </div>
@endif
