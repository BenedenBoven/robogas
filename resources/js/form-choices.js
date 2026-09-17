// ───────────────────────────────────────────────
// Velden die afhangen van een keuze in het formulier
// ───────────────────────────────────────────────
//
// Een blok met data-choice-group="naam:waarde" staat alleen open als de radio
// "naam" op "waarde" staat. Velden in een dicht blok worden uitgeschakeld, zodat
// ze niet meegaan met de inzending en niet in de mail verschijnen.

const toggleGroups = (form) => {
    form.querySelectorAll('[data-choice-group]').forEach((group) => {
        const [name, value] = group.dataset.choiceGroup.split(':');
        const checked       = form.querySelector('input[name="' + name + '"]:checked');
        const open          = checked !== null && checked.value === value;

        group.hidden = !open;
        group.querySelectorAll('input, select, textarea').forEach((field) => {
            field.disabled = !open;
        });
    });
};

document.querySelectorAll('form.default-form').forEach((form) => {
    if(!form.querySelector('[data-choice-group]')) {
        return;
    }

    form.addEventListener('change', (event) => {
        if(event.target.matches('[data-choice-input]')) {
            toggleGroups(form);
        }
    });

    toggleGroups(form);
});
