{{--
    Verplicht vinkje voor de privacyverklaring. Hier komt ook een reCAPTCHA-fout
    terecht: het is het laatste veld boven de knop; zie VerifyRecaptcha.

    @var Page|null $privacyPage  @uses PrivacyPage
--}}
<div class="form-field flex flex-col gap-1.5">
    <label class="flex items-start gap-3 cursor-pointer">
        <input type="checkbox" name="privacy" value="1" class="peer sr-only"/>
        <span aria-hidden="true" class="shrink-0 size-5 mt-0.5 border-2 border-grey-400 bg-white flex items-center justify-center transition-all duration-300 peer-checked:bg-blue peer-checked:border-blue peer-checked:[&>i]:opacity-100 peer-focus-visible:ring-3 peer-focus-visible:ring-blue-light-200 [&.is-invalid]:border-yellow-700">
            <i class="fa-solid fa-check text-white text-xs opacity-0 transition-opacity duration-300"></i>
        </span>
        <span class="text-sm">
            Ik ga akkoord met de
            @if($privacyPage)
                <a href="{{ $privacyPage->url }}" target="_blank" class="font-bold underline hover:text-blue">privacyverklaring</a>
            @else
                privacyverklaring
            @endif
        </span>
    </label>
    <span class="invalid-feedback hidden text-sm font-medium text-yellow-700 items-center gap-1.5">
        <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
    </span>
</div>
