<?php declare(strict_types=1);

namespace App\Domains\Service\Contracts;

use App\Domains\Service\Models\Service;
use Illuminate\Support\Collection;

interface ServiceRepositoryInterface {

    /**
     * Alle gepubliceerde stappen in volgorde. De positie in deze lijst is het
     * stapnummer.
     *
     * @return Collection<int, Service>
     */
    public function getAll(): Collection;

}
