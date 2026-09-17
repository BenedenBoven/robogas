<?php declare(strict_types=1);

namespace App\Infrastructure\Traits;

/**
 * Opsommingen die in het beheer als tekstvak met één punt per regel worden
 * ingevoerd, zoals "Wat wij doen" bij een dienst of "Voordelen" bij een doelgroep.
 */
trait HasLineLists {

    /** @return list<string> */
    protected function linesOf(string $attribute): array {
        return array_values(array_filter(array_map('trim', preg_split('/\R/', (string)$this->getAttribute($attribute)))));
    }
}
