<?php declare(strict_types=1);

namespace App\Support;

enum TaxonomyMap: int {

    case NOT_FOUND   = 1;
    case HOME        = 2;
    case SERVICES    = 4;
    case AUDIENCES   = 5;
    case KNOWLEDGE   = 6;
    case ABOUT       = 7;
    case CAREERS     = 8;
    case BIOGAS      = 9;
    case FAQ         = 10;
    case CONTACT     = 11;
    case ORDER       = 12;
    case QUOTE       = 13;
    case MALFUNCTION = 14;
    case TERMS       = 39;
    case PRIVACY     = 40;

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