<?php declare(strict_types=1);

namespace App\Domains\Step\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Eén regel uit een lijst op een pagina: een stap, een kerncijfer of een
 * mijlpaal (zie StepList). Hangt polymorf aan het model waar de lijst bij
 * hoort; zie HasSteps.
 *
 * @property integer     $id
 * @property string      $list     zie StepList
 * @property string|null $label    getal of jaartal vóór de titel
 * @property string      $title
 * @property string|null $summary
 * @property integer     $prio
 */
final class Step extends Model {

    protected $table = 'rg_steps';
    protected $fillable = ['model_type', 'model_id', 'list', 'label', 'title', 'summary', 'prio'];

    public function model(): MorphTo {
        return $this->morphTo();
    }

    /** Een stap zonder titel valt niet te tonen. */
    public function isFilled(): bool {
        return trim((string)$this->title) !== '';
    }
}
