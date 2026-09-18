<?php declare(strict_types=1);

namespace App\Infrastructure\ViewComposers\Pages;

use App\Infrastructure\Attributes\ComposerDescription;
use App\Infrastructure\Attributes\ComposesViews;
use App\Support\TaxonomyMap;

#[ComposesViews(
    'knowledge.list'
)]
#[ComposerDescription('De pagina Veelgestelde vragen, als bestemming vanaf Onze kennis.', 'faqPage')]
final readonly class FaqPage extends AbstractPageComposer {

    protected function taxonomyMap(): TaxonomyMap {
        return TaxonomyMap::FAQ;
    }

    protected function viewKey(): string {
        return 'faqPage';
    }
}
