<?php declare(strict_types=1);

namespace App\Infrastructure\Traits;

use App\Atom\Steps\SaveHandlers\SaveSteps;
use App\Atom\Steps\StepList;
use App\Domains\Step\Models\Step;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Geeft een model een of meer lijsten (stappen, kerncijfers, mijlpalen), elk
 * met een eigen tabblad in het beheer. Welke lijsten, zegt stepLists().
 *
 * Het model dat deze trait gebruikt en zelf getExtraAtomTabs() of
 * customSaveHandlers definieert, moet die samenvoegen; zie Page. Zet de
 * relaties hieronder in $excludedRelationships, anders toont Atom ze als
 * koppeling in het formulier.
 */
trait HasSteps {

    /** @return list<StepList> */
    abstract public function stepLists(): array;

    public function steps(): MorphMany {
        return $this->stepList(StepList::STEPS);
    }

    public function facts(): MorphMany {
        return $this->stepList(StepList::FACTS);
    }

    public function milestones(): MorphMany {
        return $this->stepList(StepList::MILESTONES);
    }

    public function stepList(StepList $list): MorphMany {
        return $this->morphMany(Step::class, 'model')->where('list', $list->value)->orderBy('prio');
    }

    /** @return list<array{title: string, id: string, icon: string, includeFile: string, stepList: StepList}> */
    public function getStepsAtomTabs(): array {
        return array_map(static fn(StepList $list) => [
            'title'       => $list->tabTitle(),
            'id'          => 'steps-' . $list->value,
            'icon'        => $list->icon(),
            // De view leest de lijst uit $extraTabItem, dat Atom bij het
            // includen van een tabblad in scope heeft.
            'includeFile' => 'atom-steps::steps',
            'stepList'    => $list,
        ], $this->stepLists());
    }

    /** Eén handler voor alle lijsten; hij leest zelf welke lijsten het model heeft. */
    public function getStepsSaveHandler(): array {
        return $this->stepLists() !== [] ? ['steps' => SaveSteps::class] : [];
    }
}
