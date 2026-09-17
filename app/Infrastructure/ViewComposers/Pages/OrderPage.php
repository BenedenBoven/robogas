<?php declare(strict_types=1);

namespace App\Infrastructure\ViewComposers\Pages;

use App\Infrastructure\Attributes\ComposerDescription;
use App\Infrastructure\Attributes\ComposesViews;
use App\Support\TaxonomyMap;

#[ComposesViews(
    'audiences.show'
)]
#[ComposerDescription('De pagina Gas bestellen, als bestemming voor bestelknoppen.', 'orderPage')]
final readonly class OrderPage extends AbstractPageComposer {

    protected function taxonomyMap(): TaxonomyMap {
        return TaxonomyMap::ORDER;
    }

    protected function viewKey(): string {
        return 'orderPage';
    }
}
