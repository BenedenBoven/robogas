{{--
Name: Sollicitatieformulier
Fields: name, phone, email
Textareas: comments
Required: name, phone, email:email, privacy:accepted

De regels hierboven leest GetFormByFile uit dit bestand: ze bepalen de validatie
en de opbouw van de mail. Laat ze staan, met een regeleinde erachter. De vacature
en de bestanden staan er niet in: die regels staan in SubmitApplication, en de
mail zet ze apart.

@var Vacancy $vacancy  @uses geërfde scope van de view
--}}
<form action="{{ url('/api/sollicitatie') }}" method="post" enctype="multipart/form-data" novalidate class="default-form flex flex-col gap-6">
    <input type="hidden" name="vacancy_id" value="{{ $vacancy->id }}"/>
    <div class="grid md:grid-cols-2 gap-6">
        @include('components.form.field', ['fieldLabel' => 'Voor- en achternaam', 'fieldName' => 'name', 'fieldRequired' => true, 'fieldAutocomplete' => 'name'])
        @include('components.form.field', ['fieldLabel' => 'Telefoonnummer', 'fieldName' => 'phone', 'fieldType' => 'tel', 'fieldRequired' => true, 'fieldAutocomplete' => 'tel'])
    </div>
    @include('components.form.field', ['fieldLabel' => 'E-mailadres', 'fieldName' => 'email', 'fieldType' => 'email', 'fieldRequired' => true, 'fieldAutocomplete' => 'email'])
    @include('components.form.file-upload', ['uploadLabel' => 'Cv en motivatie', 'uploadName' => 'files', 'uploadRequired' => true])
    @include('components.form.field', ['fieldLabel' => 'Toelichting', 'fieldName' => 'comments', 'fieldTextarea' => true, 'fieldPlaceholder' => 'Wil je nog iets kwijt? Bijvoorbeeld wanneer je kunt beginnen.'])
    @include('components.form.privacy')
    @include('components.form.submit', ['submitLabel' => 'Sollicitatie versturen'])
</form>
