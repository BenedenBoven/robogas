<?php declare(strict_types=1);

namespace App\Domains\Step\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Eén stap uit een genummerde lijst. Hangt polymorf aan het model waar de lijst
 * bij hoort; zie HasSteps.
 *
 * @property integer     $id
 * @property string      $title
 * @property string|null $summary
 * @property integer     $prio
 */
final class Step extends Model {

    protected $table = 'rg_steps';
    protected $fillable = ['model_type', 'model_id', 'title', 'summary', 'prio'];

    public function model(): MorphTo {
        return $this->morphTo();
    }

    /** Een stap zonder titel valt niet te tonen. */
    public function isFilled(): bool {
        return trim((string)$this->title) !== '';
    }
}
