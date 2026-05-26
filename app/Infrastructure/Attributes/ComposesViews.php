<?php declare(strict_types=1);

namespace App\Infrastructure\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class ComposesViews {

    /** @var array<string> */
    public array $views;

    public function __construct(string ...$views) {
        $this->views = $views;
    }
}
