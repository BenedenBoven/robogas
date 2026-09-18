{{--
    Vacature — detail. Staat niet in het ontwerp: de band-header en de opbouw
    van de dienstpagina, met een zijbalk om te solliciteren.

    @var Taxonomy       $taxonomy     @uses ShowVacancy
    @var Vacancy        $vacancy      @uses ShowVacancy
    @var Page|null      $contactPage  @uses ContactPage
    @var CompanyDetails $company      @uses CompanyDetailsComposer
--}}
@extends('layouts.app')

@section('header')
    @include('components.page-hero', [
        'heroVariant' => 'band',
        'heroTitle'   => $vacancy->title,
        'heroEyebrow' => $vacancy->meta ?: null,
        'heroIntro'   => $vacancy->summary,
    ])
@endsection

@section('content')
    <section class="py-24 2xl:py-32 bg-white">
        <div class="max-w-6xl mx-auto relative z-10 grid xl:grid-cols-[2fr_1fr] gap-12 xl:gap-16 items-start">
            <div>
                @if($vacancy->body)
                    {!! editable($vacancy, 'body', 'div', 'page-content max-w-[70ch]') !!}
                @endif
            </div>
            <aside class="xl:sticky xl:top-36 flex flex-col gap-4">
                <div class="bg-yellow rounded-4xl p-8 xl:p-10">
                    <h2 class="text-2xl font-extrabold text-black">Solliciteren?</h2>
                    <p class="mt-2 mb-5 text-black">Stuur ons een bericht of bel. We bellen dezelfde week terug.</p>
                    <div class="flex flex-wrap gap-3">
                        @if($contactPage)
                            <a href="{{ $contactPage->url }}" class="btn btn-dark">Solliciteren</a>
                        @endif
                        <a href="{{ $company->phoneHref() }}" class="btn btn-primary">{{ $company->phone() }}</a>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    @include('components.image-band', ['bandMedia' => $vacancy->header, 'bandHeight' => 'h-80 lg:h-104'])
@endsection
