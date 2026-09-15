<div class="grid xl:grid-cols-3 gap-8 xl:gap-16 2xl:gap-32 -mt-32">
    <div class="xl:col-span-2 bg-white p-12 xl:p-16 rounded-4xl shadow-xl">
        <h2 class="text-3xl lg:text-4xl pb-6">{{ $taxonomy->title }}</h2>
        {!! editable($taxonomy->getModel(), 'body', 'div', 'page-content') !!}
    </div>
    <div class="relative">
        <div class="sticky top-44 bg-blue-light-200 p-12 xl:p-16 rounded-4xl">
            <div class="page-content">
                <h5 class="font-bold uppercase text-black">Meer informatie?</h5>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod te.</p>
                <a href="" class="btn btn-primary">Lees meer</a>
            </div>
        </div>
    </div>
</div>
