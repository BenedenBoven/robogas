@php use BenedenBoven\Atom\Modules\Media\Models\Media;use Illuminate\Support\Collection; @endphp
@php
    /** @var Collection<int, Media> $images */
@endphp
@if(isset($images))
    @if($images->count() > ($amount ?? 0))
        <div class="relative {{ $padding ?? '' }}">
            <div class="gridzy gallery gridzyAnimated gridzyClassic" data-gridzy-layout="justified"
                 data-gridzy-spaceBetween="36" id="thumbnails" data-gridzy-desiredHeight="500">
                @foreach($images->skip($skip ?? 0) as $image)
                    <figure>
                        <a href="{{ $image->lg }}"
                           data-src="{{ $image->lg }}"
                           data-thumb="{{ $image->xs }}">
                            <img class="" src="{{ $image->xl }}" alt="{{ $image->title }}">
                        </a>
                    </figure>
                @endforeach
            </div>
        </div>
    @endif
@endif