@extends('layouts.app')

@section('content')
    <section class="relative min-h-[90dvh] overflow-hidden bg-blue">
        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
            <source src="{{ Vite::asset('resources/img/default.mp4') }}" type="video/mp4">
        </video>
        <div class="relative z-10 mx-auto max-w-7xl min-h-[90dvh] flex items-center ">
            <div class="max-w-7xl flex flex-col gap-4 p-0 relative ">
                <h1 class="text-black text-5xl md:text-7xl font-heading font-bold">
                    Buiten het gasnet,<br class="hidden lg:block"/>
                    binnen het comfort.
                </h1>
                <div>
                    <span class="uppercase font-heading font-extrabold bg-yellow text-black px-4 py-2">één partij voor propaangastank, techniek en levering</span>
                </div>
            </div>
            <div class="absolute bottom-34 left-auto">
                <a href="#" class="btn btn-primary btn-down shadow-none">
                    <i class="fa-regular fa-angle-down"></i>
                    Direct bestellen
                </a>
            </div>
        </div>
        <div class="h-34 rounded-t-4xl bg-white w-[calc(100%-4rem)] absolute bottom-0 left-1/2 -translate-x-1/2"></div>
    </section>
    <section class="pb-24 2xl:pb-32 bg-white relative">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-2 gap-8 items-stretch">
                <div class="relative bg-grey rounded-3xl px-10 pb-10 shadow-lg hover:shadow-xl hover:-translate-y-2 duration-300 transition-all flex flex-col gap-4 group">
                    <a href="#" class="absolute inset-0 z-20 cursor-pointer"></a>
                    <div class="w-full h-100 relative -mt-14 z-10">
                        <img src="{{ Vite::asset('resources/img/gastank.png') }}" alt=""
                             class="absolute z-4 inset-0 w-full h-full object-contain object-top drop-shadow-xl"/>
                    </div>
                    <div class="w-full flex flex-col gap-4 relative z-10 mt-auto">
                        <div>
                            <h2 class="font-light text-4xl text-black mb-1">Gastanks</h2>
                            <h4 class="font-bold text-sm uppercase text-blue">Gas voor bulkgebruik</h4>
                        </div>
                        <div class="page-content">
                            <ul class="mb-0">
                                <li>Automatisch bijvullen</li>
                                <li>Tot 70 liter</li>
                                <li>Wij komen jouw gasverbruik meten</li>
                            </ul>
                        </div>
                        <a href="#" class="btn btn-primary group-hover:btn-active">Bekijk</a>
                    </div>
                    <div class="absolute h-full w-full bottom-0 right-0 z-1 overflow-hidden">
                        <svg class="h-full w-auto ml-auto scale-105" viewBox="0 0 28.9 51.7">
                            <path class="fill-grey-100 group-hover:fill-blue-light/20 transition-all duration-1200" d="M14.3,0L4.1,10.2c-5.5,5.5-5.5,14.4,0,20l10.2-10.2c5.5-5.5,5.5-14.4,0-20"/>
                            <path class="fill-grey-100 group-hover:fill-blue-light/20 transition-all duration-1200" d="M9.5,51.7l15.2-15.2c5.5-5.5,5.5-14.4,0-20l-15.2,15.2c-5.5,5.5-5.5,14.4,0,20"/>
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col gap-8">
                    <div class="relative bg-grey rounded-3xl px-10 pb-10 shadow-lg hover:shadow-xl hover:-translate-y-2 duration-300 transition-all flex flex-row gap-4 group">
                        <a href="#" class="absolute inset-0 z-20 cursor-pointer"></a>
                        <div class="w-full flex flex-col gap-4 relative z-10 mt-auto grow">
                            <div>
                                <h2 class="font-light text-4xl text-black mb-1">Gasflessen</h2>
                                <h4 class="font-bold text-sm uppercase text-blue">Gas voor kleingebruik</h4>
                            </div>
                            <div class="page-content">
                                <ul class="mb-0">
                                    <li>Altijd op voorraad</li>
                                    <li>Tot 5 liter</li>
                                    <li>Te koop bij jouw locale benzinepomp</li>
                                </ul>
                            </div>
                            <a href="#" class="btn btn-primary group-hover:btn-active">Bekijk</a>
                        </div>
                        <div class="w-full h-100 relative -mt-14 z-10">
                            <img src="{{ Vite::asset('resources/img/gasfles.png') }}" alt=""
                                 class="absolute z-4 inset-0 w-full h-full object-contain object-top drop-shadow-xl"/>
                        </div>
                        <div class="absolute h-full w-full bottom-0 right-0 z-1 overflow-hidden">
                            <svg class="h-full w-auto ml-auto scale-105" viewBox="0 0 28.9 51.7">
                                <path class="fill-grey-100 group-hover:fill-blue-light/20 transition-all duration-1200" d="M14.3,0L4.1,10.2c-5.5,5.5-5.5,14.4,0,20l10.2-10.2c5.5-5.5,5.5-14.4,0-20"/>
                                <path class="fill-grey-100 group-hover:fill-blue-light/20 transition-all duration-1200" d="M9.5,51.7l15.2-15.2c5.5-5.5,5.5-14.4,0-20l-15.2,15.2c-5.5,5.5-5.5,14.4,0,20"/>
                            </svg>
                        </div>
                    </div>
                    <div class="relative bg-blue-light hover:bg-blue-light-700 rounded-3xl p-10 shadow-lg hover:shadow-xl hover:-translate-y-2 duration-300 transition-all flex flex-row gap-4 group">
                        <a href="#" class="absolute inset-0 z-20 cursor-pointer"></a>
                        <div class="w-full flex flex-col gap-4 relative z-10 mt-auto">
                            <div>
                                <h2 class="font-light text-4xl text-white mb-1 font-heading">Overige producten</h2>
                                <h4 class="font-bold text-sm uppercase text-white">Industriële gassen</h4>
                            </div>
                            <div class="page-content text-white">
                                <p class="mb-0">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut</p>
                            </div>
                            <a href="#" class="btn btn-primary group-hover:btn-active">Bekijk</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-black w-full h-[30%] absolute left-0 bottom-0 z-1"></div>
    </section>
    <section class="py-24 2xl:py-32 relative">
        <div class="bg-yellow w-full h-48 2xl:h-64 absolute left-0 top-0 z-1"></div>
        <div class="max-w-7xl mx-auto relative z-10 flex flex-row gap-16">
            <div class="grow aspect-video">
                <div class="w-2/3 aspect-video bg-red-200">
                    123
                </div>
            </div>
            <div class="flex flex-col gap-4 mt-auto">
                <div class="mb-5">
                    <h2 class="text-5xl">Waarom propaan?</h2>
                    <h6 class="font-bold text-sm uppercase text-blue">De vele voordelen</h6>
                </div>
                <div class="page-content text-blue-light">
                    <p>Woon of werk je buitenaf, of wil je bewust los van het vaste gasnet? RoboGas maakt propaangas vanzelfsprekend. We rekenen je verbruik door, geven een heldere offerte, regelen tankhuur en plaatsing en
                        zorgen dat
                        installatie en keuring kloppen. Daarna leveren we op tijd bij. Jij hebt het comfort van warmte, warm water en een werkend gasfornuis. Wij houden het veilig en draaiend. </p>
                </div>
                <a href="" class="btn btn-primary">Lees meer</a>
            </div>

        </div>
    </section>
@endsection
