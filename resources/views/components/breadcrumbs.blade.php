{{--
    Kruimelpad uit de taxonomy-boom, met Home ervoor. Uit het ontwerp: Breadcrumb.
    Een overzichtspagina heeft parent_id 0, dus Home zit niet in de keten en plakken we er zelf voor.

    @var Taxonomy    $taxonomy                           @uses geërfde scope van de view
    @var string|null $tone      'light' of 'dark' (grond) @uses meegegeven bij @include
--}}
@php
    $crumbDark  = ($tone ?? 'light') === 'dark';
    $crumbTrail = $taxonomy->breadcrumb()->reverse()->reject(fn($crumb) => $crumb->url === '/')->values();
@endphp
<nav aria-label="Kruimelpad" class="flex flex-wrap items-center gap-2 text-sm">
    <a href="/" @class([
        'transition-colors duration-300',
        'text-white/70 hover:text-yellow' => $crumbDark,
        'text-grey-500 hover:text-blue' => !$crumbDark,
    ])>Home</a>
    @foreach($crumbTrail as $crumb)
        <i @class(['fa-regular fa-angle-right text-[0.75em]', 'text-white/70' => $crumbDark, 'text-grey-500' => !$crumbDark]) aria-hidden="true"></i>
        @if($loop->last)
            <span aria-current="page" @class(['font-medium', 'text-white' => $crumbDark, 'text-black' => !$crumbDark])>{{ $crumb->title }}</span>
        @else
            <a href="{{ $crumb->url }}" @class([
                'transition-colors duration-300',
                'text-white/70 hover:text-yellow' => $crumbDark,
                'text-grey-500 hover:text-blue' => !$crumbDark,
            ])>{{ $crumb->title }}</a>
        @endif
    @endforeach
</nav>
