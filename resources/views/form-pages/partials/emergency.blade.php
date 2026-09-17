{{--
    Gele noodkaart in de header van Storing melden: het nummer en wat je doet
    bij een gaslucht. De stappen komen uit het tabblad Stappen van de pagina.

    @var Page           $page     @uses geërfde scope van de view
    @var CompanyDetails $company  @uses CompanyDetailsComposer
--}}
<div class="bg-yellow rounded-3xl p-6 md:p-8 mt-6 max-w-[62ch]">
    <span class="font-heading font-bold uppercase text-sm text-blue">Ruik je gas? Bel direct</span>
    <a href="{{ $company->phoneHref() }}" class="block font-heading font-extrabold text-4xl md:text-5xl text-black leading-tight mt-1 mb-4 hover:text-blue transition-colors duration-300">
        <i class="fa-solid fa-phone mr-2 text-[0.7em]" aria-hidden="true"></i>{{ $company->phone() }}
    </a>
    @if($page->steps->isNotEmpty())
        <ol class="flex flex-col gap-2">
            @foreach($page->steps as $emergencyStep)
                <li class="flex gap-3 text-black">
                    <span class="shrink-0 font-heading font-extrabold text-blue">{{ $loop->iteration }}.</span>
                    <span>{{ $emergencyStep->title }}@if($emergencyStep->summary) {{ $emergencyStep->summary }}@endif</span>
                </li>
            @endforeach
        </ol>
    @endif
</div>
