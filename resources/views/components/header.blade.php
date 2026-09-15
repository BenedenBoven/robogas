@sectionMissing('header')
    <header class="relative h-180 overflow-hidden bg-blue">
        <img src="{{ Vite::asset('resources/img/default.jpg') }}" alt="" class="absolute inset-0 w-full h-full object-cover"/>
        <div class="absolute inset-0 bg-linear-to-r from-black/30 to-black/0 from-0% to-50%"></div>
        <div class="mx-auto max-w-7xl">
            <div class="relative z-10 h-160 pt-27 flex items-center">
                <div class="flex flex-col gap-4 w-full md:w-2/3">
                    <h1 class="text-white text-5xl md:text-7xl font-heading font-bold">
                        {{ $taxonomy->long_title }}
                    </h1>
                </div>
            </div>
        </div>
    </header>
@endif

@hasSection('header')
    @yield('header')
@endif