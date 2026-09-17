{{--
    Doelgroep als rond icoon met label eronder, zoals op de homepage. Uit het ontwerp: ServiceIcon.

    @var Audience    $iconAudience                                   @uses meegegeven bij @include
    @var string|null $iconGround  'grey' of 'white' (op een tint)    @uses meegegeven bij @include
--}}
<div class="relative flex flex-col gap-4 xl:gap-6 items-center group">
    <a href="{{ $iconAudience->url }}" class="absolute inset-0 z-20 cursor-pointer" aria-label="{{ $iconAudience->title }}"></a>
    <div @class([
        'h-24 aspect-square rounded-full p-5 relative group-hover:bg-blue duration-300 transition-all group-hover:shadow-lg',
        'bg-white' => ($iconGround ?? 'grey') === 'white',
        'bg-grey' => ($iconGround ?? 'grey') !== 'white',
    ])>
        <div class="w-full h-full relative">
            <img src="{{ Vite::asset($iconAudience->icon_asset) }}" alt="" class="absolute inset-0 w-full h-full object-contain transition-all duration-300 group-hover:brightness-0 group-hover:invert"/>
        </div>
    </div>
    <span class="font-heading font-bold uppercase group-hover:text-blue text-center whitespace-nowrap group-hover:-translate-y-1.5 duration-300 transition-all">{{ $iconAudience->title }}</span>
</div>
