<?php declare(strict_types=1);

namespace App\Infrastructure\ViewComposers\Pages;

use App\Infrastructure\Attributes\ComposerDescription;
use App\Infrastructure\Attributes\ComposesViews;
use App\Support\TaxonomyMap;

#[ComposesViews(
    'services.list'
)]
#[ComposerDescription('De offertepagina, als bestemming voor de offerte-CTA.', 'quotePage')]
final readonly class QuotePage extends AbstractPageComposer {

    protected function taxonomyMap(): TaxonomyMap {
        return TaxonomyMap::QUOTE;
    }

    protected function viewKey(): string {
        return 'quotePage';
    }
}
