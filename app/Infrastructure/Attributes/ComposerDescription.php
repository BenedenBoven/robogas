<?php declare(strict_types=1);

namespace App\Infrastructure\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class ComposerDescription {

    /** @var array<string> */
    public array $provides;

    public function __construct(
        public string $description,
        string        ...$provides
    ) {
        $this->provides = $provides;
    }
}
