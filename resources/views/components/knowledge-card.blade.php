{{--
    Kennisartikel als kaart: foto met scrim, of een vlak in de kaartkleur van het
    artikel. De titel in hoofdletters onderin, de doelgroepen als labels. Uit het
    ontwerp: KnowledgeCard.

    @var Article     $knowledgeArticle                                  @uses meegegeven bij @include
    @var bool|null   $knowledgeDome     koepelvorm bovenaan (bovenste kaart van een kolom)  @uses meegegeven bij @include
    @var string|null $knowledgeHeight   Tailwind-hoogte                  @uses meegegeven bij @include
    @var string|null $knowledgeTag      h2 of h3, afhankelijk van de kop erboven  @uses meegegeven bij @include
--}}
@php
    $knowledgeColors = $knowledgeArticle->card_colors;
    $knowledgePhoto  = $knowledgeArticle->header;
    $knowledgeInk    = $knowledgePhoto ? 'text-white' : $knowledgeColors['ink'];
    $knowledgeLabel  = $knowledgePhoto ? 'bg-yellow text-black' : $knowledgeColors['tag'];
@endphp
<div class="relative group w-full {{ $knowledgeHeight ?? 'h-80 md:h-[400px]' }}" data-knowledge-card>
    <a href="{{ $knowledgeArticle->url }}" class="absolute inset-0 z-20" aria-label="{{ $knowledgeArticle->title }}"></a>
    <article @class([
        'relative h-full overflow-hidden rounded-md group-hover:-translate-y-2 duration-300 transition-all group-hover:shadow-xl',
        'rounded-t-[50%_120px]' => !empty($knowledgeDome),
    ]) data-knowledge-shape>
        @if($knowledgePhoto)
            @include('components.media-img', [
                'media'  => $knowledgePhoto,
                'format' => 'sm',
                'class'  => 'absolute inset-0 w-full h-full object-cover',
            ])
            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 duration-300 transition-all"></div>
        @else
            <div class="absolute inset-0 {{ $knowledgeColors['ground'] }} duration-300 transition-all"></div>
        @endif
        <div class="absolute inset-x-0 bottom-0 group-hover:bottom-6 duration-300 transition-all p-8 z-10 flex flex-col gap-4">
            <{{ $knowledgeTag ?? 'h3' }} class="font-bold uppercase text-base {{ $knowledgeInk }} 2xl:w-3/4 leading-6">{{ $knowledgeArticle->title }}</{{ $knowledgeTag ?? 'h3' }}>
            @if($knowledgeArticle->audiences->isNotEmpty())
                <div class="flex flex-wrap gap-2">
                    @foreach($knowledgeArticle->audiences as $knowledgeAudience)
                        @include('components.audience-label', ['labelAudience' => $knowledgeAudience, 'labelTone' => $knowledgeLabel])
                    @endforeach
                </div>
            @endif
        </div>
    </article>
</div>
