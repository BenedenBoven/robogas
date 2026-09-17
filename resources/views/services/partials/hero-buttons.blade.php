{{--
    Knoppen naar elke stap, onder de intro van het dienstenoverzicht.

    @var Collection<Service> $services  @uses geërfde scope van de view
--}}
@if($services->isNotEmpty())
    <div class="flex flex-wrap gap-3 mt-2">
        @foreach($services as $heroStep)
            <a href="{{ $heroStep->url }}" class="btn btn-primary">{{ $heroStep->title }}</a>
        @endforeach
    </div>
@endif
