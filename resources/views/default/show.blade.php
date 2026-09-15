@extends('layouts.app')

@section('content')
    <section class="pb-24 2xl:pb-32 bg-white relative">
        <div class="max-w-7xl mx-auto relative z-10 flex flex-col gap-8 xl:gap-16 2xl:gap-32">
            @include('components.elements.default-text')
            @include('components.elements.gallery')
        </div>
    </section>
    @include('components.video-block', [
        'bgBlock' => 'bg-blue-light-200'
    ])
@endsection