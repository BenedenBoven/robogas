{{--
    Vacature — detail. Staat niet in het ontwerp: de band-header en de opbouw
    van de dienstpagina, met een zijbalk en het sollicitatieformulier.

    @var Taxonomy       $taxonomy     @uses ShowVacancy
    @var Vacancy        $vacancy      @uses ShowVacancy
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
            {{-- Op kleinere schermen staat de sollicitatieband er direct onder; dan is dit blok dubbel. --}}
            <aside class="hidden xl:flex xl:sticky xl:top-36 flex-col gap-4">
                <div class="bg-yellow rounded-4xl p-8 xl:p-10">
                    <h2 class="text-2xl font-extrabold text-black">Solliciteren?</h2>
                    <p class="mt-2 mb-5 text-black">Vul het formulier in of bel. We bellen dezelfde week terug.</p>
                    <div class="flex flex-wrap gap-3">
                        <a href="#solliciteren" class="btn btn-dark">Solliciteren</a>
                        <a href="{{ $company->phoneHref() }}" class="btn btn-primary">{{ $company->phone() }}</a>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <section id="solliciteren" class="scroll-mt-28 py-24 2xl:py-32 bg-blue-light-200">
        <div class="max-w-6xl mx-auto relative z-10 grid lg:grid-cols-[1fr_1.7fr] gap-12 xl:gap-16 items-start">
            <div class="flex flex-col gap-5 lg:sticky lg:top-36">
                @include('components.section-heading', ['headingTitle' => 'Direct solliciteren', 'headingEyebrow' => $vacancy->title])
                <p class="max-w-[42ch]">Stuur je cv en een paar regels over jezelf. Een lange brief hoeft niet. Liever eerst even praten? Bel ons gerust.</p>
                <a href="{{ $company->phoneHref() }}" class="btn btn-primary self-start">{{ $company->phone() }}</a>
            </div>
            <div class="bg-white p-8 md:p-12 rounded-4xl shadow-xl">
                @include('forms.application')
            </div>
        </div>
    </section>

    @include('components.image-band', ['bandMedia' => $vacancy->header, 'bandHeight' => 'h-80 lg:h-104'])
@endsection
