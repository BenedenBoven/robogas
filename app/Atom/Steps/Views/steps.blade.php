@php
    /**
     * Eén tabblad per lijst (StepList). Atom include't deze view per tabblad
     * met $extraTabItem in scope; zie HasSteps::getStepsAtomTabs().
     *
     * @var \BenedenBoven\Atom\Nucleus\Nucleus $nucleus
     * @var array{stepList: \App\Atom\Steps\StepList} $extraTabItem
     */
    $stepList  = $extraTabItem['stepList'];
    $stepModel = $nucleus->getModel();
    $stepRows  = $stepModel->exists ? $stepModel->stepList($stepList)->get() : collect();
@endphp

<div class="col-sm-12 steps-tab" data-step-list="{{ $stepList->value }}">
    <div class="alert bb-alert alpha-purple mb-3 text-purple-800 d-flex align-items-center">
        <i class="icon fa-light fa-lightbulb"></i>
        <div>
            {{ $stepList->help() }}
            Sleep een regel aan het greepje om hem te verplaatsen. Opslaan gaat met de gewone knop onderaan.
        </div>
        <button type="button" class="close text-purple-800 ml-auto" data-dismiss="alert"><i class="icon-cross2"></i></button>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th style="width: 1%"></th>
            @if($stepList->numbered())
                <th style="width: 1%">#</th>
            @endif
            <th>{{ $stepList->tabTitle() }}</th>
            <th style="width: 1%"></th>
        </tr>
        </thead>
        <tbody class="step-rows">
        @foreach($stepRows as $index => $step)
            @include('atom-steps::partials.row', [
                'stepList' => $stepList,
                'index'    => $index,
                'id'       => $step->id,
                'label'    => $step->label,
                'title'    => $step->title,
                'summary'  => $step->summary,
            ])
        @endforeach
        </tbody>
    </table>

    {{-- Eigen marge: bootstrap_limitless zet .table op margin-bottom 0. --}}
    <button type="button" class="atom-btn atom-btn-secondary atom-btn-sm mt-3 step-add">{{ $stepList->addLabel() }}</button>

    {{-- Dezelfde rij als hierboven, zodat een toegevoegde regel niet afwijkt. --}}
    <template class="step-row-template">
        @include('atom-steps::partials.row', ['stepList' => $stepList, 'index' => '__INDEX__', 'id' => null, 'label' => null, 'title' => null, 'summary' => null])
    </template>
</div>

{{-- Eén keer, ook als de pagina meer lijsten heeft: het script bedient elk tabblad. --}}
@once
    @section('scripts')
        @parent
        {{-- SortableJS staat al in Atom, maar wordt niet standaard ingeladen; zie ook
             adminnav, dat zijn eigen sorteerplugin op dezelfde manier meeneemt. --}}
        <script src="/administrator/global_assets/js/plugins/sortable/sortable.js"></script>
        <script>
            document.querySelectorAll('.steps-tab').forEach(function(tab) {
                const rows     = tab.querySelector('.step-rows');
                const add      = tab.querySelector('.step-add');
                const template = tab.querySelector('.step-row-template');

                if(!rows || !add || !template) {
                    return;
                }

                // Doorlopend nummer voor de veldnamen: dat hoeft alleen uniek te zijn,
                // de volgorde bepaalt de server aan de hand van de rijvolgorde.
                let next = rows.querySelectorAll('tr').length;

                /** Het zichtbare volgnummer gelijktrekken met de werkelijke volgorde. */
                function renumber() {
                    rows.querySelectorAll('.step-row').forEach(function(row, index) {
                        const badge = row.querySelector('.step-number');

                        if(badge) {
                            badge.textContent = String(index + 1).padStart(2, '0');
                        }
                    });
                }

                add.addEventListener('click', function() {
                    rows.insertAdjacentHTML('beforeend', template.innerHTML.replaceAll('__INDEX__', String(next++)));
                    rows.lastElementChild.querySelector('input[type="text"]')?.focus();
                    renumber();
                });

                rows.addEventListener('click', function(event) {
                    const row = event.target.closest('.step-row');

                    if(row && event.target.closest('.step-remove')) {
                        row.remove();
                        renumber();
                    }
                });

                // Slepen aan het greepje; de rijvolgorde in het formulier bepaalt de
                // volgorde op de site, dus er hoeft niets naar de server bij het
                // verplaatsen. Opslaan gaat mee met de gewone knop.
                if(typeof Sortable !== 'undefined') {
                    Sortable.create(rows, {
                        handle:    '.step-handle',
                        animation: 150,
                        onEnd:     renumber
                    });
                }

                renumber();
            });
        </script>
    @endsection
@endonce
