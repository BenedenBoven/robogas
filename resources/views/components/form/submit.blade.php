{{--
    Melding, verzendknop en reCAPTCHA onderaan een formulier.
    Zonder sleutel krijgt de knop geen g-recaptcha-klasse: dan verstuurt
    submit-form.js het formulier zelf en blijft het werken.

    @var string      $submitLabel               @uses meegegeven bij @include
    @var string|null $submitNote  regel boven de knop  @uses meegegeven bij @include
--}}
@if(!empty($submitNote))
    <p class="text-sm text-grey-500">{{ $submitNote }}</p>
@endif

<div role="status" class="form-validation hidden border-l-5 border-blue bg-blue-light-200 p-6 [&.alert-danger]:border-yellow-700 [&.alert-danger]:bg-yellow-50">
    <span class="font-heading font-extrabold text-black"></span>
</div>

<div>
    <button type="submit"
            class="btn btn-dark @if(config('services.recaptcha.key')) g-recaptcha @endif"
            @if(config('services.recaptcha.key'))
                data-sitekey="{{ config('services.recaptcha.key') }}"
                data-callback="submitForm"
            @endif>{{ $submitLabel }}</button>
</div>

@if(config('services.recaptcha.key'))
    @once
        @push('scripts')
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endpush
    @endonce
@endif
