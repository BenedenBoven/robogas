{{--
Name: Contactformulier
Fields: name, phone, email, comments
Textareas: comments
Required: name, phone, email:email, comments, privacy:accepted

De regels hierboven leest GetFormByFile uit dit bestand: ze bepalen de validatie
en de opbouw van de mail. Laat ze staan, met een regeleinde erachter.

@var Page|null $privacyPage  @uses PrivacyPage
--}}
<form action="{{ url('/api/forms/' . \App\Support\FormType::CONTACT->value) }}" method="post" novalidate class="default-form flex flex-col gap-6">
    <div class="grid md:grid-cols-2 gap-6">
        @include('components.form.field', ['fieldLabel' => 'Voor- en achternaam', 'fieldName' => 'name', 'fieldRequired' => true, 'fieldAutocomplete' => 'name'])
        @include('components.form.field', ['fieldLabel' => 'Telefoonnummer', 'fieldName' => 'phone', 'fieldType' => 'tel', 'fieldRequired' => true, 'fieldAutocomplete' => 'tel'])
    </div>
    @include('components.form.field', ['fieldLabel' => 'E-mailadres', 'fieldName' => 'email', 'fieldType' => 'email', 'fieldRequired' => true, 'fieldAutocomplete' => 'email'])
    @include('components.form.field', ['fieldLabel' => 'Bericht', 'fieldName' => 'comments', 'fieldTextarea' => true, 'fieldRequired' => true, 'fieldPlaceholder' => 'Waar kunnen we mee helpen?'])
    @include('components.form.privacy')
    @include('components.form.submit', ['submitLabel' => 'Versturen', 'submitNote' => $page->block_subtitle])
</form>
