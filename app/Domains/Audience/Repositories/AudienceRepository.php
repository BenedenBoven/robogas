<?php declare(strict_types=1);

namespace App\Domains\Audience\Repositories;

use App\Domains\Audience\Contracts\AudienceRepositoryInterface;
use App\Domains\Audience\Models\Audience;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final readonly class AudienceRepository implements AudienceRepositoryInterface {

    public function getAll(): Collection {
        return $this->getBaseQuery()->orderBy('rg_audiences.priority')->get();
    }

    private function getBaseQuery(): Builder {
        return Audience::query()->published()->joined();
    }

}
