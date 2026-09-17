<?php declare(strict_types=1);

namespace App\Domains\Page\Repositories;

use App\Domains\Page\Contracts\PageRepositoryInterface;
use App\Domains\Page\Models\Page;
use App\Support\TaxonomyMap;
use Illuminate\Database\Eloquent\Builder;

final readonly class PageRepository implements PageRepositoryInterface {

    public function getByTaxonomyMap(TaxonomyMap $map): ?Page {
        return $this->getBaseQuery()->where('atom_taxonomies.id', $map->value)->first();
    }

    private function getBaseQuery(): Builder {
        return Page::query()->published()->joined();
    }

}
