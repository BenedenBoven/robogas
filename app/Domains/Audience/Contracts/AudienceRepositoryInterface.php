<?php declare(strict_types=1);

namespace App\Domains\Audience\Contracts;

use App\Domains\Audience\Models\Audience;
use Illuminate\Support\Collection;

interface AudienceRepositoryInterface {

    /**
     * Alle gepubliceerde doelgroepen in de volgorde uit het beheer.
     *
     * @return Collection<int, Audience>
     */
    public function getAll(): Collection;

}
