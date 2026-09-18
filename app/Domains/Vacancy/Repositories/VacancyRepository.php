<?php declare(strict_types=1);

namespace App\Domains\Vacancy\Repositories;

use App\Domains\Vacancy\Contracts\VacancyRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use App\Domains\Vacancy\Models\Vacancy;
use Illuminate\Support\Collection;

final readonly class VacancyRepository implements VacancyRepositoryInterface {

    public function getAll(): Collection {
        return $this->getBaseQuery()->orderBy('rg_vacancies.priority')->get();
    }

    public function find(int $id): ?Vacancy {
        return $this->getBaseQuery()->where('rg_vacancies.id', $id)->first();
    }

    public function count(): int {
        return $this->getBaseQuery()->count();
    }

    private function getBaseQuery(): Builder {
        return Vacancy::query()->published()->joined();
    }

}
