{{--
Name: Offerte aanvragen
Fields: name, company, email, phone, address, place, audience, service, usage, start, comments
Textareas: comments
Required: name, email:email, phone, address, place, privacy:accepted

De regels hierboven leest GetFormByFile uit dit bestand: ze bepalen de validatie
en de opbouw van de mail. Laat ze staan, met een regeleinde erachter.

@var Page|null            $privacyPage  @uses PrivacyPage
@var Collection<Audience> $audiences    @uses ShowFormPage
--}}
<form action="{{ url('/api/forms/' . \App\Support\FormType::QUOTE->value) }}" method="post" novalidate class="default-form flex flex-col gap-6">
    <div class="grid md:grid-cols-2 gap-6">
        @include('components.form.field', ['fieldLabel' => 'Voor- en achternaam', 'fieldName' => 'name', 'fieldRequired' => true, 'fieldAutocomplete' => 'name'])
        @include('components.form.field', ['fieldLabel' => 'Bedrijfsnaam', 'fieldName' => 'company', 'fieldPlaceholder' => 'Optioneel', 'fieldAutocomplete' => 'organization'])
    </div>
    <div class="grid md:grid-cols-2 gap-6">
        @include('components.form.field', ['fieldLabel' => 'E-mailadres', 'fieldName' => 'email', 'fieldType' => 'email', 'fieldRequired' => true, 'fieldAutocomplete' => 'email'])
        @include('components.form.field', ['fieldLabel' => 'Telefoonnummer', 'fieldName' => 'phone', 'fieldType' => 'tel', 'fieldRequired' => true, 'fieldAutocomplete' => 'tel'])
    </div>
    <div class="grid md:grid-cols-2 gap-6">
        @include('components.form.field', ['fieldLabel' => 'Adres', 'fieldName' => 'address', 'fieldRequired' => true, 'fieldAutocomplete' => 'street-address'])
        @include('components.form.field', ['fieldLabel' => 'Postcode en plaats', 'fieldName' => 'place', 'fieldRequired' => true])
    </div>
    <div class="grid md:grid-cols-2 gap-6">
        @include('components.form.field', ['fieldLabel' => 'Doelgroep', 'fieldName' => 'audience', 'fieldOptions' => [...$audiences->pluck('title')->all(), 'Anders']])
        @include('components.form.field', ['fieldLabel' => 'Waar gaat het om?', 'fieldName' => 'service', 'fieldOptions' => ['Nieuwe tank plaatsen', 'Overstappen van leverancier', 'Losse levering', 'Onderhoud of keuring', 'Advies']])
    </div>
    <div class="grid md:grid-cols-2 gap-6">
        @include('components.form.field', ['fieldLabel' => 'Verwacht jaarverbruik', 'fieldName' => 'usage', 'fieldOptions' => ['Weet ik niet', 'Minder dan 1.000 liter', '1.000 - 3.000 liter', '3.000 - 10.000 liter', 'Meer dan 10.000 liter'], 'fieldHint' => 'Weet je het niet? Wij rekenen het voor je door.'])
        @include('components.form.field', ['fieldLabel' => 'Gewenste startdatum', 'fieldName' => 'start', 'fieldType' => 'date'])
    </div>
    @include('components.form.field', ['fieldLabel' => 'Toelichting', 'fieldName' => 'comments', 'fieldTextarea' => true, 'fieldPlaceholder' => 'Wat stook je nu, en wat wil je bereiken?'])
    @include('components.form.privacy')
    @include('components.form.submit', ['submitLabel' => 'Offerte aanvragen', 'submitNote' => $page->block_subtitle])
</form>
