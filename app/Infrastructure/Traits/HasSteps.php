<?php declare(strict_types=1);

namespace App\Infrastructure\Traits;

use App\Atom\Steps\SaveHandlers\SaveSteps;
use App\Domains\Step\Models\Step;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Geeft een model een genummerde lijst stappen, met een eigen tab in het beheer.
 *
 * Het model dat deze trait gebruikt en zelf getExtraAtomTabs() of
 * customSaveHandlers definieert, moet die samenvoegen; zie Page.
 */
trait HasSteps {

    public function steps(): MorphMany {
        return $this->morphMany(Step::class, 'model')->orderBy('prio');
    }

    /**
     * Alleen de stappen met een titel, voor de website.
     *
     * @return Collection<int, Step>
     */
    public function filledSteps(): Collection {
        return $this->steps->filter(fn(Step $step) => $step->isFilled())->values();
    }

    public function getStepsAtomTab(): array {
        return [
            'title'       => 'Stappen',
            'id'          => 'steps',
            'icon'        => 'fa-regular fa-list-ol',
            'includeFile' => 'atom-steps::steps',
        ];
    }

    public function getStepsSaveHandler(): array {
        return ['steps' => SaveSteps::class];
    }
}
