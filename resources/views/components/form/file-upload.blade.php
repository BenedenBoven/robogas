{{--
    Bestanden toevoegen met FilePond (resources/js/file-upload.js). FilePond zet
    de bestanden terug in dit invoerveld, zodat ze als gewone upload met het
    formulier meegaan en de server ze zelf controleert.

    FilePond leest de toegestane typen uit accept; dat moeten MIME-typen zijn,
    geen extensies. Typen en maximale grootte staan ook in SubmitApplication;
    houd ze gelijk.

    @var string    $uploadLabel                                                  @uses meegegeven bij @include
    @var string    $uploadName                                                   @uses meegegeven bij @include
    @var bool|null $uploadRequired  alleen het sterretje; de regel staat in de handler  @uses meegegeven bij @include
--}}
<div class="form-field flex flex-col gap-1.5">
    <label for="field-{{ $uploadName }}" class="font-heading font-bold text-sm text-black">
        {{ $uploadLabel }}@if(!empty($uploadRequired))<span class="text-blue"> *</span>@endif
    </label>

    <input id="field-{{ $uploadName }}" name="{{ $uploadName }}[]" type="file" multiple class="file-upload"
           accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/png" data-max-files="5" data-max-file-size="10MB"/>

    <span class="text-sm text-grey-500">Pdf, Word of foto, tot 10 MB per bestand en maximaal 5 bestanden.</span>

    <span class="invalid-feedback hidden text-sm font-medium text-yellow-700 items-center gap-1.5">
        <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
    </span>
</div>
