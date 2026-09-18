<?php declare(strict_types=1);

namespace App\Domains\Vacancy\Contracts;

use App\Domains\Vacancy\Models\Vacancy;
use Illuminate\Support\Collection;

interface VacancyRepositoryInterface {

    /**
     * Alle gepubliceerde vacatures in de volgorde uit het beheer.
     *
     * @return Collection<int, Vacancy>
     */
    public function getAll(): Collection;

    /** Het aantal gepubliceerde vacatures, voor de teller in het menu. */
    public function count(): int;

}
