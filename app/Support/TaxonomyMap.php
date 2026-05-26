<?php declare(strict_types=1);

namespace App\Support;

enum TaxonomyMap: int {

    case NOT_FOUND = 1;
    case HOME      = 2;

    public function isDeletable(): bool {
        return match ($this) {
            default => false,
        };
    }

    public static function getNonDeletable(): array {
        return array_map(
            fn(self $case) => $case->value,
            array_filter(self::cases(), fn(self $case) => !$case->isDeletable())
        );
    }


    public static function fromId(int $id): ?self {
        return self::tryFrom($id);
    }
}