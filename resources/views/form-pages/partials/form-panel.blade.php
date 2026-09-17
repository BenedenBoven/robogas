{{--
    Wit paneel met schaduw om een formulier, met titel en intro uit de blokvelden.

    @var Page     $page      @uses geërfde scope van de view
    @var FormType $formType  @uses geërfde scope van de view
--}}
<div class="bg-white p-8 md:p-12 rounded-4xl shadow-xl">
    @if($page->block_title)
        <h2 class="text-3xl lg:text-4xl font-extrabold">{{ $page->block_title }}</h2>
    @endif
    @if($page->block_content)
        {!! editable($page, 'block_content', 'div', 'page-content mt-3 max-w-[62ch] [&>p:last-child]:mb-0') !!}
    @endif
    <div class="mt-8">
        @include('forms.' . $formType->value)
    </div>
</div>
