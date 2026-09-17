{{--
Name: Gas bestellen
Fields: customer_type, name, company, email, phone, address, place, customer_number, level, building, usage, period, amount, comments
Textareas: comments
Required: customer_type, name, email:email, phone, address, place, privacy:accepted

De regels hierboven leest GetFormByFile uit dit bestand: ze bepalen de validatie
en de opbouw van de mail. Laat ze staan, met een regeleinde erachter.
Velden in een dicht keuzeblok worden niet verstuurd en staan in de mail als
"niet ingevuld".

@var Page|null $privacyPage  @uses PrivacyPage
--}}
<form action="{{ url('/api/forms/' . \App\Support\FormType::ORDER->value) }}" method="post" novalidate class="default-form flex flex-col gap-6">
    @include('components.form.choice-cards', [
        'choiceLabel'   => 'Ben je al klant?',
        'choiceName'    => 'customer_type',
        'choiceOptions' => [
            ['value' => 'Bestaande klant', 'label' => 'Ik ben al klant', 'description' => 'Je bestelt bij op je bestaande tank.', 'icon' => 'fa-solid fa-fire'],
            ['value' => 'Nieuwe klant', 'label' => 'Ik ben nieuwe klant', 'description' => 'We rekenen je verbruik door en plaatsen de tank.', 'icon' => 'fa-solid fa-house'],
        ],
    ])
    <div class="grid md:grid-cols-2 gap-6">
        @include('components.form.field', ['fieldLabel' => 'Voor- en achternaam', 'fieldName' => 'name', 'fieldRequired' => true, 'fieldAutocomplete' => 'name'])
        @include('components.form.field', ['fieldLabel' => 'Bedrijfsnaam', 'fieldName' => 'company', 'fieldPlaceholder' => 'Optioneel', 'fieldAutocomplete' => 'organization'])
    </div>
    <div class="grid md:grid-cols-2 gap-6">
        @include('components.form.field', ['fieldLabel' => 'E-mailadres', 'fieldName' => 'email', 'fieldType' => 'email', 'fieldRequired' => true, 'fieldAutocomplete' => 'email'])
        @include('components.form.field', ['fieldLabel' => 'Telefoonnummer', 'fieldName' => 'phone', 'fieldType' => 'tel', 'fieldRequired' => true, 'fieldAutocomplete' => 'tel'])
    </div>
    <div class="grid md:grid-cols-2 gap-6">
        @include('components.form.field', ['fieldLabel' => 'Adres leverlocatie', 'fieldName' => 'address', 'fieldRequired' => true, 'fieldAutocomplete' => 'street-address'])
        @include('components.form.field', ['fieldLabel' => 'Postcode en plaats', 'fieldName' => 'place', 'fieldRequired' => true])
    </div>
    <div class="grid md:grid-cols-2 gap-6" data-choice-group="customer_type:Bestaande klant">
        @include('components.form.field', ['fieldLabel' => 'Klantnummer', 'fieldName' => 'customer_number', 'fieldHint' => 'Staat op je factuur.'])
        @include('components.form.field', ['fieldLabel' => 'Huidige tankstand', 'fieldName' => 'level', 'fieldOptions' => ['Weet ik niet', 'Meer dan 50%', 'Ongeveer 30%', 'Minder dan 20%']])
    </div>
    <div class="grid md:grid-cols-2 gap-6" data-choice-group="customer_type:Nieuwe klant">
        @include('components.form.field', ['fieldLabel' => 'Type gebouw of bedrijf', 'fieldName' => 'building', 'fieldOptions' => ['Woning', 'Agrarisch bedrijf', 'Recreatiepark of horeca', 'Bouwplaats of industrie', 'Anders']])
        @include('components.form.field', ['fieldLabel' => 'Verwacht jaarverbruik', 'fieldName' => 'usage', 'fieldOptions' => ['Weet ik niet', 'Minder dan 1.000 liter', '1.000 - 3.000 liter', '3.000 - 10.000 liter', 'Meer dan 10.000 liter'], 'fieldHint' => 'Weet je het niet? Wij rekenen het voor je door.'])
    </div>
    <div class="grid md:grid-cols-2 gap-6">
        @include('components.form.field', ['fieldLabel' => 'Gewenste bestelperiode', 'fieldName' => 'period', 'fieldOptions' => ['Zo snel mogelijk', 'Binnen twee weken', 'Binnen een maand', 'In overleg']])
        @include('components.form.field', ['fieldLabel' => 'Gewenste hoeveelheid', 'fieldName' => 'amount', 'fieldOptions' => ['Tank vol', '500 liter', '1.000 liter', 'Anders, zie opmerking']])
    </div>
    @include('components.form.field', ['fieldLabel' => 'Opmerking', 'fieldName' => 'comments', 'fieldTextarea' => true, 'fieldPlaceholder' => 'Bijvoorbeeld: hek zit op slot, bel vooraf even.'])
    @include('components.form.privacy')
    @include('components.form.submit', ['submitLabel' => 'Bestelling versturen', 'submitNote' => $page->block_subtitle])
</form>
