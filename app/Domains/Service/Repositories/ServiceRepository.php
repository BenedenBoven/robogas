<?php declare(strict_types=1);

namespace App\Domains\Service\Repositories;

use App\Domains\Service\Contracts\ServiceRepositoryInterface;
use App\Domains\Service\Models\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final readonly class ServiceRepository implements ServiceRepositoryInterface {

    public function getAll(): Collection {
        return $this->getBaseQuery()->orderBy('rg_services.priority')->get();
    }

    private function getBaseQuery(): Builder {
        return Service::query()->published()->joined();
    }

}
