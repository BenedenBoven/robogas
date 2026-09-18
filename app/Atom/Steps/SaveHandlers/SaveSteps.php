<?php declare(strict_types=1);

namespace App\Atom\Steps\SaveHandlers;

use App\Atom\Steps\StepList;
use App\Domains\Step\Models\Step;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Slaat de lijsten (stappen, kerncijfers, mijlpalen) op bij het bewaren van een
 * pagina. Elke lijst staat in de request onder zijn eigen sleutel; zie StepList.
 *
 * Hangt als 'after'-handler aan het model, zodat de stappen meegaan met de
 * gewone opslagknop van Atom. Een los opslagmoment zou betekenen dat iemand het
 * formulier bewaart en denkt dat de stappen ook mee zijn.
 *
 * De invoer wordt uit de request gelezen en niet uit het meegegeven veld:
 * Nucleus stelt zijn veldenlijst samen uit de kolommen van de tabel, en dit
 * staat in een eigen array buiten het model om.
 */
final readonly class SaveSteps {

    public function __construct(
        private Request $request
    ) {}

    public function save(Model $model, mixed $field = null): void {
        foreach($model->stepLists() as $list) {
            // Een lijst die niet in de request staat, is niet meegestuurd (een
            // ander formulier, een API-aanroep) en niet leeggemaakt.
            if($this->request->has($list->value)) {
                $this->saveList($model, $list, (array)$this->request->input($list->value, []));
            }
        }
    }

    /** @param array<int|string, array<string, mixed>> $rows */
    private function saveList(Model $model, StepList $list, array $rows): void {
        $kept = [];
        $prio = 0;

        foreach($rows as $row) {
            $title = trim((string)($row['title'] ?? ''));

            // Zonder titel is er niets te tonen; dat is een lege regel uit het
            // formulier die de redactie niet gebruikt heeft.
            if($title === '') {
                continue;
            }

            $label   = trim((string)($row['label'] ?? ''));
            $summary = trim((string)($row['summary'] ?? ''));
            $id      = (int)($row['id'] ?? 0);

            // Bestaande regel bijwerken op id, zodat het hernoemen van een regel
            // geen nieuwe rij oplevert. Alleen binnen dezelfde lijst.
            $step = $id > 0 ? $this->query($model, $list)->find($id) : null;

            $step ??= new Step(['model_type' => $model->getMorphClass(), 'model_id' => $model->getKey(), 'list' => $list->value]);

            $step->fill([
                'label'   => $list->labelPlaceholder() !== null && $label !== '' ? $label : null,
                'title'   => $title,
                'summary' => $list->summaryPlaceholder() !== null && $summary !== '' ? $summary : null,
                'prio'    => $prio++,
            ])->save();

            $kept[] = $step->getKey();
        }

        // Regels die niet meer in het formulier stonden, heeft de redactie
        // verwijderd; die horen ook uit de database te verdwijnen.
        $this->query($model, $list)
            ->when($kept !== [], fn($query) => $query->whereNotIn('id', $kept))
            ->delete();
    }

    private function query(Model $model, StepList $list): Builder {
        return Step::query()
            ->where('model_type', $model->getMorphClass())
            ->where('model_id', $model->getKey())
            ->where('list', $list->value);
    }
}
