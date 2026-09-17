{{--
    Formulierveld met label, hint en foutmelding. Uit het ontwerp: Field.
    submit-form.js zoekt de foutmelding binnen .form-field en maakt hem zichtbaar
    zodra de server valideert. Validatie loopt via de server: geen required-attribuut.

    @var string      $fieldLabel                                                  @uses meegegeven bij @include
    @var string      $fieldName                                                   @uses meegegeven bij @include
    @var string|null $fieldType      text, email, tel, date; standaard text        @uses meegegeven bij @include
    @var array|null  $fieldOptions   vul dit voor een keuzelijst                   @uses meegegeven bij @include
    @var bool|null   $fieldTextarea  true voor een tekstvak                        @uses meegegeven bij @include
    @var bool|null   $fieldRequired  alleen het sterretje; de regel staat bovenaan het formulier  @uses meegegeven bij @include
    @var string|null $fieldHint                                                   @uses meegegeven bij @include
    @var string|null $fieldPlaceholder                                            @uses meegegeven bij @include
    @var string|null $fieldAutocomplete                                           @uses meegegeven bij @include
--}}
@php($fieldControl = 'w-full font-body font-light text-base leading-snug text-black bg-white border border-grey-300 px-3.5 py-3 outline-none transition-all duration-300 placeholder:text-grey-400 hover:border-grey-400 focus:border-blue focus:ring-3 focus:ring-blue-light-200 [&.is-invalid]:border-yellow-700 [&.is-invalid]:ring-3 [&.is-invalid]:ring-yellow-100')

<div class="form-field flex flex-col gap-1.5">
    <label for="field-{{ $fieldName }}" class="font-heading font-bold text-sm text-black">
        {{ $fieldLabel }}@if(!empty($fieldRequired))<span class="text-blue"> *</span>@endif
    </label>

    @if(!empty($fieldOptions))
        <div class="relative">
            <select id="field-{{ $fieldName }}" name="{{ $fieldName }}" class="{{ $fieldControl }} appearance-none pr-10 cursor-pointer">
                @foreach($fieldOptions as $fieldOption)
                    <option value="{{ $fieldOption }}">{{ $fieldOption }}</option>
                @endforeach
            </select>
            <i class="fa-solid fa-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-black pointer-events-none" aria-hidden="true"></i>
        </div>
    @elseif(!empty($fieldTextarea))
        <textarea id="field-{{ $fieldName }}" name="{{ $fieldName }}" rows="5" placeholder="{{ $fieldPlaceholder ?? '' }}" class="{{ $fieldControl }} min-h-36 resize-y"></textarea>
    @else
        <input id="field-{{ $fieldName }}" name="{{ $fieldName }}" type="{{ $fieldType ?? 'text' }}" placeholder="{{ $fieldPlaceholder ?? '' }}"
               @if(!empty($fieldAutocomplete)) autocomplete="{{ $fieldAutocomplete }}" @endif class="{{ $fieldControl }}"/>
    @endif

    @if(!empty($fieldHint))
        <span class="text-sm text-grey-500">{{ $fieldHint }}</span>
    @endif

    <span class="invalid-feedback hidden text-sm font-medium text-yellow-700 items-center gap-1.5">
        <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
    </span>
</div>
