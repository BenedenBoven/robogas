{{--
    Aanvraagpagina: Gas bestellen, Offerte aanvragen of Storing melden.
    Band-header, formulier met zijbalk, wat er hierna gebeurt en veelgestelde vragen.
    Bij Storing melden staan de stappen als noodstappen in de header.

    @var Taxonomy             $taxonomy     @uses ShowFormPage
    @var Page                 $page         @uses ShowFormPage
    @var FormType             $formType     @uses ShowFormPage
    @var Collection<FaqTheme> $faqThemes    @uses ShowFormPage
    @var Collection<Audience> $audiences    alleen bij de offerte  @uses ShowFormPage
    @var Page|null            $contactPage  @uses ContactPage
    @var CompanyDetails       $company      @uses CompanyDetailsComposer
--}}
@extends('layouts.app')

@php $isMalfunction = $formType === \App\Support\FormType::MALFUNCTION; @endphp

@section('header')
    @include('components.page-hero', [
        'heroVariant' => 'band',
        'heroTitle'   => $page->long_title,
        'heroEyebrow' => $page->subtitle,
        'heroIntro'   => $page->summary,
        'heroAppend'  => $isMalfunction ? 'form-pages.partials.emergency' : null,
    ])
@endsection

@section('content')
    <section class="pt-24 2xl:pt-32 pb-12 bg-white">
        <div class="max-w-6xl mx-auto relative z-10 grid xl:grid-cols-[2fr_1fr] gap-12 xl:gap-16">
            @include('form-pages.partials.form-panel')

            @if($page->body)
                <div class="relative">
                    <div class="sticky top-36 bg-blue-light-200 p-8 xl:p-12 rounded-4xl">
                        {!! editable($page, 'body', 'div', 'page-content [&>p:last-child]:mb-5') !!}
                        @if($contactPage)
                            <a href="{{ $contactPage->url }}" class="btn btn-primary">Contact opnemen</a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>

    @unless($isMalfunction)
        @include('components.next-steps', ['nextSteps' => $page->steps])
    @endunless

    @include('components.faq-accordion')
@endsection
