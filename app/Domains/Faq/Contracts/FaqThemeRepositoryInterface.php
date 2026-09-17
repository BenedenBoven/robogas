<?php declare(strict_types=1);

namespace App\Domains\Faq\Contracts;

use App\Domains\Faq\Models\FaqTheme;
use Illuminate\Support\Collection;

interface FaqThemeRepositoryInterface {

    /**
     * De thema's die op deze pagina staan, met hun gepubliceerde vragen. Thema's
     * zonder vragen vallen weg.
     *
     * @return Collection<int, FaqTheme>
     */
    public function getForPage(int $pageId): Collection;

}
