{{--
    Homepage: de doelgroepen als iconenrij.

    @var Collection<Audience> $audiences  @uses AudiencesComposer
--}}
@if($audiences->isNotEmpty())
    <section class="py-24 2xl:py-32 relative">
        <div class="max-w-6xl mx-auto relative z-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-none xl:grid-flow-col xl:auto-cols-fr gap-8 xl:w-fit">
            @foreach($audiences as $homeAudience)
                @include('components.audience-icon', ['iconAudience' => $homeAudience])
            @endforeach
        </div>
    </section>
@endif
