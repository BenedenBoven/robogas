@extends('layouts.app')

@section('content')
    <div class="container-xl mx-auto bg-blue-light-100 h-200">
        <h1 class="text-5xl">{{ $taxonomy->getModel()->title }}</h1>
    </div>
@endsection
