<section class="py-24 2xl:py-32 relative">
    <div class="bg-black w-full h-48 2xl:h-64 absolute left-0 top-0 z-1"></div>
    <div class="max-w-7xl mx-auto relative z-10 flex flex-col xl:flex-row items-start gap-16 2xl:gap-32">
        <div class="xl:w-3/5">
            <div class="w-full aspect-video gallery relative group overflow-hidden video-hover">
                <figure class="absolute inset-0">
                    <a href="{{ Vite::asset('resources/img/default.mp4') }}" data-src="{{ Vite::asset('resources/img/default.mp4') }}" data-thumb="{{ Vite::asset('resources/img/default.jpg') }}" data-rel="index-gallery"
                       class="block w-full h-full">
                        <video class="hover-video w-full h-full object-cover transition-transform duration-500 group-hover:scale-102" src="{{ Vite::asset('resources/img/default.mp4') }}" muted playsinline preload="auto"></video>
                    </a>
                </figure>
                <div class="absolute left-5 bottom-5 h-14 w-14 flex items-center justify-center pointer-events-none transition-all duration-300 group-hover:opacity-0 group-hover:scale-75">
                    <div class="absolute inset-0 rounded-full border border-white/40 transition-all duration-700 ease-out group-hover:scale-150 group-hover:opacity-0"></div>
                    <div class="relative h-14 w-14 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center transition-all duration-500 ease-out group-hover:scale-110 group-hover:bg-white/30">
                        <div class="h-10 w-10 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center transition-all duration-500 ease-out group-hover:scale-90 group-hover:bg-white/20">
                            <i class="fa-regular fa-play text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="xl:w-2/5 flex flex-col gap-4 xl:mt-32 2xl:mt-64">
            <div class="mb-5">
                <h2 class="text-5xl">Waarom propaan?</h2>
                <h6 class="font-bold text-sm uppercase text-blue">De vele voordelen</h6>
            </div>
            <div class="page-content text-blue-light line-clamp-5">
                <p>
                    Woon of werk je buitenaf, of wil je bewust los van het vaste gasnet? RoboGas maakt propaangas vanzelfsprekend. We rekenen je verbruik door, geven een heldere offerte, regelen tankhuur en plaatsing en zorgen dat
                    installatie en keuring kloppen. Daarna leveren we op tijd bij. Jij hebt het comfort van warmte, warm water en een werkend gasfornuis. Wij houden het veilig en draaiend.
                </p>
            </div>
            <a href="" class="btn btn-primary">Lees meer</a>
        </div>
    </div>
</section>