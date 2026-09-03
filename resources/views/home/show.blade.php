@extends('layouts.app')

@section('content')
    <section class="relative min-h-[90dvh] overflow-hidden bg-blue">
        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
            <source src="{{ Vite::asset('resources/img/default.mp4') }}" type="video/mp4">
        </video>
        <div class="relative z-10 mx-auto max-w-7xl min-h-[90dvh] flex items-center">
            <div class="max-w-7xl flex flex-col gap-4 pt-22 xl:pt-27 p-0">
                <h1 class="text-black text-5xl md:text-7xl font-heading font-bold">
                    Buiten het gasnet,<br class="hidden lg:block"/>
                    binnen comfort.
                </h1>
                <div>
                    <span class="uppercase font-heading font-extrabold bg-yellow text-black px-4 py-2">één partij voor propaangastank, techniek en levering</span>
                </div>
            </div>
        </div>
    </section>
    <section class="py-24 2xl:py-32 min-h-[80dvh] bg-black">
    </section>
@endsection
