<?php declare(strict_types=1);

namespace App\Domains\Page\Contracts;

use App\Domains\Page\Models\Page;
use App\Support\TaxonomyMap;

interface PageRepositoryInterface {

    /**
     * Een vaste pagina op haar plek in de TaxonomyMap, inclusief url.
     * Voor de page composers die CTA-bestemmingen leveren.
     */
    public function getByTaxonomyMap(TaxonomyMap $map): ?Page;

}
