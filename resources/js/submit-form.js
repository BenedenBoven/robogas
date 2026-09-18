import axios from 'axios';

/**
 * Verstuurt een formulier naar de API en toont de melding of de fouten.
 *
 * Wordt op twee manieren aangeroepen: door reCAPTCHA als data-callback, met het
 * token als argument, en anders door de submit-afhandeling hieronder wanneer er
 * geen captcha ingesteld is.
 *
 * Alle validatie gebeurt aan de serverkant; de velden hebben bewust geen
 * required-attribuut en het formulier staat op novalidate.
 */
const verstuur = (form, gRecaptchaResponse) => {
    const submitButton     = form.querySelector('[type="submit"]');
    const currentInnerHtml = submitButton.innerHTML;

    submitButton.classList.add('disabled');
    submitButton.disabled  = true;
    submitButton.innerHTML = '<i class="fa-solid fa-spinner-third fa-spin ms-0 mt-1 mb-1"></i>';

    const formData = new FormData(form);

    if(gRecaptchaResponse) {
        formData.append('g-recaptcha-response', gRecaptchaResponse);
    }

    const melding = form.querySelector('.form-validation');

    melding.classList.add('hidden');
    melding.classList.remove('alert-danger');

    // Ook de inline display weghalen die toonFouten zet, anders wint die van
    // hidden en blijven oude fouten staan na een nieuwe poging.
    form.querySelectorAll('.invalid-feedback').forEach((element) => {
        element.classList.add('hidden');
        element.style.display = '';
    });
    form.querySelectorAll('.is-invalid').forEach((element) => element.classList.remove('is-invalid'));

    axios.post(form.action, formData).then((response) => {
        if(response.data.message) {
            toonMelding(melding, response.data.message);
            form.innerHTML = '';
            form.appendChild(melding);
        }
    }).catch((exception) => {
        const fouten = exception.response?.data?.errors;

        if(fouten) {
            toonFouten(form, fouten);

            // De captcha teruggezet, anders is het token verbruikt en levert een
            // tweede poging altijd opnieuw een captchafout op.
            if(window.grecaptcha) {
                window.grecaptcha.reset();
            }

            return;
        }

        // Geen validatiefouten betekent dat er iets anders misging: een storing,
        // geen verbinding, of te veel pogingen. Zonder deze tak zou de bezoeker
        // een formulier zien dat niets doet.
        toonMelding(
            melding,
            exception.response?.status === 429
                ? 'Er zijn te veel pogingen gedaan. Probeer het over een minuut opnieuw.'
                : 'Er ging iets mis bij het versturen. Probeer het later opnieuw of bel ons.',
            true
        );
    }).finally(() => {
        submitButton.classList.remove('disabled');
        submitButton.disabled  = false;
        submitButton.innerHTML = currentInnerHtml;
    });
};

const toonMelding = (melding, tekst, isFout = false) => {
    const doel = melding.querySelector('span') ?? melding;

    doel.innerHTML = tekst;
    melding.classList.remove('hidden');
    melding.classList.toggle('alert-danger', isFout);
    melding.classList.toggle('alert-success', !isFout);
};

const toonFouten = (form, fouten) => {
    for(const veld in fouten) {
        const element = form.querySelector('[name="' + veld + '"]');

        if(element === null) {
            continue;
        }

        // Alleen binnen het eigen veld zoeken. Een terugval op het hele
        // formulier zette de fout onder het eerste veld zodra een component
        // zelf geen invalid-feedback had.
        const wrapper  = element.closest('.form-field');
        const feedback = wrapper?.querySelector('.invalid-feedback');

        if(!feedback) {
            continue;
        }

        // Bij een checkbox is het echte element verborgen; het zichtbare vakje
        // ernaast krijgt de rode rand.
        (element.type === 'checkbox' || element.type === 'radio'
            ? element.parentNode.querySelector('span[aria-hidden]') ?? element
            : element).classList.add('is-invalid');

        const melding = fouten[veld][0];

        feedback.innerText = melding.charAt(0).toUpperCase() + melding.slice(1);
        feedback.classList.remove('hidden');
        feedback.style.display = 'flex';
    }

    // Naar het eerste veld met een fout, anders staat de melding mogelijk buiten beeld.
    form.querySelector('.is-invalid')?.scrollIntoView({behavior: 'smooth', block: 'center'});
};

/**
 * reCAPTCHA roept dit aan zonder te zeggen om welk formulier het gaat, dus dat
 * leiden we af uit de knop die op dat moment bezig is.
 */
window.submitForm = (gRecaptchaResponse) => {
    const knop = document.querySelector('.g-recaptcha[data-callback="submitForm"]:focus')
        ?? document.querySelector('form.default-form .g-recaptcha');

    const form = knop?.closest('form.default-form') ?? document.querySelector('form.default-form');

    if(form) {
        verstuur(form, gRecaptchaResponse);
    }
};

// Zonder captchasleutel krijgt de knop geen g-recaptcha-klasse en dus geen
// afhandeling van Google; dan versturen we het formulier hier.
document.addEventListener('submit', (event) => {
    const form = event.target;

    if(!form.classList?.contains('default-form') || form.querySelector('.g-recaptcha')) {
        return;
    }

    event.preventDefault();
    verstuur(form, null);
});
