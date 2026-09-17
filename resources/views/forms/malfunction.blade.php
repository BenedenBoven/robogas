{{--
Name: Storing melden
Fields: name, customer_number, phone, email, address, malfunction_type, comments
Textareas: comments
Required: name, phone, email:email, address, comments, privacy:accepted

De regels hierboven leest GetFormByFile uit dit bestand: ze bepalen de validatie
en de opbouw van de mail. Laat ze staan, met een regeleinde erachter.

@var Page|null $privacyPage  @uses PrivacyPage
--}}
<form action="{{ url('/api/forms/' . \App\Support\FormType::MALFUNCTION->value) }}" method="post" novalidate class="default-form flex flex-col gap-6">
    <div class="grid md:grid-cols-2 gap-6">
        @include('components.form.field', ['fieldLabel' => 'Voor- en achternaam', 'fieldName' => 'name', 'fieldRequired' => true, 'fieldAutocomplete' => 'name'])
        @include('components.form.field', ['fieldLabel' => 'Klantnummer', 'fieldName' => 'customer_number', 'fieldHint' => 'Staat op je factuur.'])
    </div>
    <div class="grid md:grid-cols-2 gap-6">
        @include('components.form.field', ['fieldLabel' => 'Telefoonnummer', 'fieldName' => 'phone', 'fieldType' => 'tel', 'fieldRequired' => true, 'fieldHint' => 'Hier bellen we je op terug.', 'fieldAutocomplete' => 'tel'])
        @include('components.form.field', ['fieldLabel' => 'E-mailadres', 'fieldName' => 'email', 'fieldType' => 'email', 'fieldRequired' => true, 'fieldAutocomplete' => 'email'])
    </div>
    <div class="grid md:grid-cols-2 gap-6">
        @include('components.form.field', ['fieldLabel' => 'Adres installatie', 'fieldName' => 'address', 'fieldRequired' => true, 'fieldAutocomplete' => 'street-address'])
        @include('components.form.field', ['fieldLabel' => 'Soort storing', 'fieldName' => 'malfunction_type', 'fieldOptions' => ['Geen gas / installatie valt uit', 'Lekkage of drukverlies', 'Regelaar of meter defect', 'Schade aan de tank', 'Anders']])
    </div>
    @include('components.form.field', ['fieldLabel' => 'Omschrijving', 'fieldName' => 'comments', 'fieldTextarea' => true, 'fieldRequired' => true, 'fieldPlaceholder' => 'Wat merk je, sinds wanneer, en wat heb je al geprobeerd?'])
    @include('components.form.privacy')
    @include('components.form.submit', ['submitLabel' => 'Melding versturen', 'submitNote' => $page->block_subtitle])
</form>
