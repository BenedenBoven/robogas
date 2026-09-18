{{--
    Eén regel uit een lijst. Ook gebruikt als sjabloon voor regels die in de
    browser bijkomen; daar staat __INDEX__ in plaats van een nummer.

    Het volgnummer is geen invoerveld: het komt uit de volgorde van de rijen en
    wordt door de JS bijgewerkt zodra er iets verschuift. Welke velden er zijn,
    bepaalt de lijst; zie StepList.

    @var \App\Atom\Steps\StepList $stepList
    @var int|string               $index
    @var int|null                 $id
    @var string|null              $label
    @var string|null              $title
    @var string|null              $summary
--}}
@php($stepField = $stepList->value . '[' . $index . ']')
<tr class="step-row">
    {{-- De hele cel is de greep, niet alleen het icoon: een los <i> is maar een
         paar pixels groot en dan grijp je er telkens naast. Zelfde sleepicoon
         als het overzicht van Atom gebruikt. --}}
    <td class="step-handle text-center align-middle" style="width: 1%; cursor: grab; user-select: none"
        title="Versleep om te verplaatsen">
        <i class="fa-solid fa-up-down text-muted"></i>
    </td>
    @if($stepList->numbered())
        <td class="text-center align-middle" style="width: 1%">
            <span class="step-number badge badge-flat border-purple text-purple-800">00</span>
        </td>
    @endif
    <td>
        <input type="hidden" name="{{ $stepField }}[id]" value="{{ $id }}">
        <div class="d-flex" style="gap: .5rem">
            @if($stepList->labelPlaceholder() !== null)
                <input type="text" class="form-control mb-2" style="flex: 0 0 9rem" name="{{ $stepField }}[label]"
                       value="{{ $label }}" placeholder="{{ $stepList->labelPlaceholder() }}">
            @endif
            <input type="text" class="form-control mb-2" name="{{ $stepField }}[title]"
                   value="{{ $title }}" placeholder="{{ $stepList->titlePlaceholder() }}">
        </div>
        @if($stepList->summaryPlaceholder() !== null)
            <textarea class="form-control" rows="2" name="{{ $stepField }}[summary]"
                      placeholder="{{ $stepList->summaryPlaceholder() }}">{{ $summary }}</textarea>
        @endif
    </td>
    <td style="width: 1%" class="align-middle">
        <button type="button" class="btn btn-light btn-icon step-remove" title="Regel verwijderen"><i class="mi-delete-forever"></i></button>
    </td>
</tr>
