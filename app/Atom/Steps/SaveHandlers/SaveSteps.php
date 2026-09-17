<?php declare(strict_types=1);

namespace App\Atom\Steps\SaveHandlers;

use App\Domains\Step\Models\Step;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Slaat de stappen op bij het bewaren van een pagina.
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
        if(!$this->request->has('steps')) {
            return;
        }

        $rows = (array)$this->request->input('steps', []);
        $kept = [];
        $prio = 0;

        foreach($rows as $row) {
            $title = trim((string)($row['title'] ?? ''));

            // Zonder titel is er niets te tonen; dat is een lege regel uit het
            // formulier die de redactie niet gebruikt heeft.
            if($title === '') {
                continue;
            }

            $summary = trim((string)($row['summary'] ?? ''));
            $id      = (int)($row['id'] ?? 0);

            // Bestaande regel bijwerken op id, zodat het hernoemen van een stap
            // geen nieuwe rij oplevert.
            $step = $id > 0
                ? Step::query()->where('model_type', $model->getMorphClass())->where('model_id', $model->getKey())->find($id)
                : null;

            $step ??= new Step(['model_type' => $model->getMorphClass(), 'model_id' => $model->getKey()]);

            $step->fill([
                'title'   => $title,
                'summary' => $summary !== '' ? $summary : null,
                'prio'    => $prio++,
            ])->save();

            $kept[] = $step->getKey();
        }

        $this->removeMissing($model, $kept);
    }

    /**
     * Stappen die niet meer in het formulier stonden zijn verwijderd door de
     * redactie en horen ook uit de database te verdwijnen.
     *
     * @param array<int, int> $kept
     */
    private function removeMissing(Model $model, array $kept): void {
        Step::query()
            ->where('model_type', $model->getMorphClass())
            ->where('model_id', $model->getKey())
            ->when($kept !== [], fn($query) => $query->whereNotIn('id', $kept))
            ->delete();
    }
}
