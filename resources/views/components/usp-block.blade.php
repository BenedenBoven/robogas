<section class="py-24 2xl:py-32 relative overflow-x-clip" data-knowledge-section>
    <div class="bg-blue-light-200 w-full sm:w-[calc(100%-64px)] h-full absolute left-0 bottom-0 z-1 sm:mx-8"></div>

    <div class="max-w-6xl mx-auto relative min-h-[900px]">

        {{-- Achtergrondvorm --}}
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-10" data-floating-shape>
            <svg class="h-full w-auto" viewBox="0 0 28.9 51.7">
                <path class="fill-blue-light-300"
                      d="M14.3,0L4.1,10.2c-5.5,5.5-5.5,14.4,0,20l10.2-10.2c5.5-5.5,5.5-14.4,0-20"/>
                <path class="fill-blue-light-300"
                      d="M9.5,51.7l15.2-15.2c5.5-5.5,5.5-14.4,0-20l-15.2,15.2c-5.5,5.5-5.5,14.4,0,20"/>
            </svg>
        </div>

        {{-- Titel --}}
        <div
                data-title-block
                class="absolute z-10 left-1/2 top-1/4 md:top-1/2 -translate-x-1/2 -translate-y-1/2 text-center w-full max-w-3xl"
        >
            <h2 class="text-5xl xl:text-7xl font-bold text-black">
                66 jaar ervaring.<br>
                Eén doel: jouw comfort.
            </h2>

            <p class="mt-8 font-bold font-heading uppercase text-blue">
                We weten wanneer je moet bijvullen.
            </p>
        </div>

        {{-- Hotspot 1 --}}
        <div class="absolute z-20 bottom-[34%] md:bottom-auto md:top-[12%] left-8 md:left-[52%]" data-hotspot data-open="true">
            <button
                    type="button"
                    class="relative w-16 h-16 rounded-full bg-white shadow-xl flex items-center justify-center cursor-pointer"
            >
                <span data-plus class="absolute text-4xl text-grey-400">
                    +
                </span>

                <span data-icon class="absolute inset-0 flex items-center justify-center">
                    <i class="fa-solid fa-people-group text-blue text-2xl"></i>
                </span>
            </button>

            <div class="absolute left-20 top-1/2 -translate-y-1/2 w-[320px] max-w-[calc(100vw-9rem)]">
                <div data-content>
                    <h3 class="font-bold uppercase text-blue mb-2">
                        Familiebedrijf in het midden van Nederland
                    </h3>

                    <p class="text-blue/70">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </p>
                </div>
            </div>
        </div>

        {{-- Hotspot 2 --}}
        <div class="absolute z-20 bottom-[6%] left-8 md:left-[35%] xl:left-[38%]" data-hotspot>
            <button
                    type="button"
                    class="relative w-16 h-16 rounded-full bg-white shadow-xl flex items-center justify-center cursor-pointer"
            >
                <span data-plus class="absolute text-4xl text-grey-400">
                    +
                </span>

                <span data-icon class="absolute inset-0 flex items-center justify-center">
                    <i class="fa-solid fa-handshake text-blue text-2xl"></i>
                </span>
            </button>

            <div class="absolute left-20 md:left-auto md:right-20 top-1/2 -translate-y-1/2 w-[320px] max-w-[calc(100vw-9rem)] text-left md:text-right">
                <div data-content>
                    <h3 class="font-bold uppercase text-blue mb-2">
                        Persoonlijke service
                    </h3>

                    <p class="text-blue/70">
                        Altijd dichtbij en persoonlijk bereikbaar.
                    </p>
                </div>
            </div>
        </div>

        {{-- Hotspot 3 --}}
        <div class="absolute z-20 bottom-[20%] left-8 md:left-auto right-auto md:right-[35%] xl:right-[38%]" data-hotspot>
            <button
                    type="button"
                    class="relative w-16 h-16 rounded-full bg-white shadow-xl flex items-center justify-center cursor-pointer"
            >
                <span data-plus class="absolute text-4xl text-grey-400">
                    +
                </span>

                <span data-icon class="absolute inset-0 flex items-center justify-center">
                    <i class="fa-solid fa-clock-rotate-left text-blue text-2xl"></i>
                </span>
            </button>

            <div class="absolute left-20 top-1/2 -translate-y-1/2 w-[320px] max-w-[calc(100vw-9rem)]">
                <div data-content>
                    <h3 class="font-bold uppercase text-blue mb-2">
                        66 jaar ervaring
                    </h3>

                    <p class="text-blue/70">
                        Kennis en ervaring waarop je kunt vertrouwen.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>