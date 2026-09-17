{{--
    Keuze als kaarten met een rondje. Uit het ontwerp: ChoiceCard.
    Met data-choice-group op een blok elders in het formulier wordt dat blok
    alleen getoond bij de bijbehorende keuze; zie resources/js/form-choices.js.

    @var string $choiceLabel                                          @uses meegegeven bij @include
    @var string $choiceName                                           @uses meegegeven bij @include
    @var array  $choiceOptions  [['value', 'label', 'description'?, 'icon'?]]  eerste is standaard  @uses meegegeven bij @include
--}}
<fieldset class="form-field flex flex-col gap-2.5">
    <legend class="font-heading font-bold text-sm text-black mb-2.5">{{ $choiceLabel }}</legend>
    <div class="grid sm:grid-cols-2 gap-4">
        @foreach($choiceOptions as $choiceOption)
            <label class="group/choice relative flex gap-4 items-start p-5 bg-white border border-grey-300 cursor-pointer transition-colors duration-300 hover:border-blue-light has-checked:border-blue has-checked:bg-blue-light-50">
                <input type="radio" name="{{ $choiceName }}" value="{{ $choiceOption['value'] }}" @checked($loop->first) class="peer sr-only" data-choice-input/>
                <span class="shrink-0 size-5 mt-0.5 rounded-full border-2 border-grey-400 flex items-center justify-center transition-colors duration-300 peer-checked:border-blue peer-focus-visible:ring-3 peer-focus-visible:ring-blue-light-200" aria-hidden="true">
                    <span class="size-2.5 rounded-full bg-blue scale-0 transition-transform duration-300 group-has-checked/choice:scale-100"></span>
                </span>
                <span class="flex flex-col gap-1">
                    <span class="font-heading font-extrabold text-black">
                        @if(!empty($choiceOption['icon']))<i class="{{ $choiceOption['icon'] }} text-blue mr-2" aria-hidden="true"></i>@endif{{ $choiceOption['label'] }}
                    </span>
                    @if(!empty($choiceOption['description']))
                        <span class="text-sm text-grey-600 leading-normal">{{ $choiceOption['description'] }}</span>
                    @endif
                </span>
            </label>
        @endforeach
    </div>
    <span class="invalid-feedback hidden text-sm font-medium text-yellow-700 items-center gap-1.5">
        <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
    </span>
</fieldset>
