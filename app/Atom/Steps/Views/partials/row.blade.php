{{--
    Eén stap uit de lijst. Ook gebruikt als sjabloon voor stappen die in de
    browser bijkomen; daar staat __INDEX__ in plaats van een nummer.

    Het volgnummer is geen invoerveld: het komt uit de volgorde van de rijen en
    wordt door de JS bijgewerkt zodra er iets verschuift.

    @var int|string  $index
    @var int|null    $id
    @var string|null $title
    @var string|null $summary
--}}
<tr class="step-row">
    {{-- De hele cel is de greep, niet alleen het icoon: een los <i> is maar een
         paar pixels groot en dan grijp je er telkens naast. Zelfde sleepicoon
         als het overzicht van Atom gebruikt. --}}
    <td class="step-handle text-center align-middle" style="width: 1%; cursor: grab; user-select: none"
        title="Versleep om te verplaatsen">
        <i class="fa-solid fa-up-down text-muted"></i>
    </td>
    <td class="text-center align-middle" style="width: 1%">
        <span class="step-number badge badge-flat border-purple text-purple-800">00</span>
        <input type="hidden" name="steps[{{ $index }}][id]" value="{{ $id }}">
    </td>
    <td>
        <input type="text" class="form-control mb-2" name="steps[{{ $index }}][title]"
               value="{{ $title }}" placeholder="Bijvoorbeeld We plannen de rit">
        <textarea class="form-control" rows="2" name="steps[{{ $index }}][summary]"
                  placeholder="Korte toelichting op deze stap">{{ $summary }}</textarea>
    </td>
    <td style="width: 1%" class="align-middle">
        <button type="button" class="btn btn-light btn-icon step-remove" title="Stap verwijderen"><i class="mi-delete-forever"></i></button>
    </td>
</tr>
