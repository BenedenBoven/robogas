<?php declare(strict_types=1);

namespace App\Domains\Page\Contracts;

use App\Domains\Page\Models\Page;
use App\Support\TaxonomyMap;
use Illuminate\Support\Collection;

interface PageRepositoryInterface {

    /**
     * Een vaste pagina op haar plek in de TaxonomyMap, inclusief url.
     * Voor de page composers die CTA-bestemmingen leveren.
     */
    public function getByTaxonomyMap(TaxonomyMap $map): ?Page;

    /**
     * Meerdere vaste pagina's in één query, op taxonomy-id. Een pagina die offline
     * staat ontbreekt in de uitkomst.
     *
     * @param  list<TaxonomyMap> $maps
     * @return Collection<int, Page>
     */
    public function getByTaxonomyMaps(array $maps): Collection;

}
