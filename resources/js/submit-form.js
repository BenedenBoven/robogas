import axios from 'axios';

const submitForm = (gRecaptchaResponse) => {
    const form = document.querySelector('form.default-form');

    const submitButton     = form.querySelector('[type="submit"]');
    const currentInnerHtml = submitButton.innerHTML;
    submitButton.classList.add('disabled');
    submitButton.disabled  = true;
    submitButton.innerHTML = '<i class="fad fa-spinner-third fa-spin ms-0 mt-1 mb-1"></i>';

    const formData = new FormData(form);
    formData.append('g-recaptcha-response', gRecaptchaResponse);

    const validationAlert = document.querySelector('.form-validation');
    validationAlert.classList.add('hidden');
    validationAlert.classList.remove('alert-danger');

    document.querySelectorAll('.invalid-feedback').forEach((element) => {
        if(!element.classList.contains('hidden')) {
            element.classList.add('hidden');
        }
    });

    document.querySelectorAll('.is-invalid').forEach((element) => {
        element.classList.remove('is-invalid');
    });

    axios.post(form.action, formData).then((response) => {
        if(response.data.message) {
            validationAlert.querySelector('span').innerHTML = response.data.message;
            validationAlert.classList.add('alert-success');
            validationAlert.classList.remove('hidden');

            form.innerHTML = '';
        }
    }).catch((exception) => {
        if(exception.response.data.errors) {
            for(let error in exception.response.data.errors) {
                const el = form.querySelector('[name="' + error + '"]');

                if(el !== null) {
                    el.classList.add('is-invalid');
                }
                const feedback = el.parentNode.querySelector('.hidden') || el.parentNode.parentNode.querySelector('.hidden');

                if(feedback !== null) {
                    feedback.classList.remove('hidden');

                    const string = exception.response.data.errors[error][0];

                    feedback.innerText = string.charAt(0).toUpperCase() + string.slice(1);

                    const style = window.getComputedStyle(feedback);
                    if(style.display === 'none') {
                        feedback.style.display = 'block';
                    }
                }
            }
        }
    }).finally(() => {
        submitButton.classList.remove('disabled');
        submitButton.disabled  = false;
        submitButton.innerHTML = currentInnerHtml;
    });
}

window.submitForm = submitForm;
