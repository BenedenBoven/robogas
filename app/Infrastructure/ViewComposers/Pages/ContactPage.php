<?php declare(strict_types=1);

namespace App\Infrastructure\ViewComposers\Pages;

use App\Infrastructure\Attributes\ComposerDescription;
use App\Infrastructure\Attributes\ComposesViews;
use App\Support\TaxonomyMap;

#[ComposesViews(
    'services.list',
    'services.show',
    'audiences.list',
    'form-pages.show',
    'knowledge.list',
    'knowledge.show',
    'knowledge.faq',
    'vacancies.list',
    'about.show'
)]
#[ComposerDescription('De contactpagina, als bestemming voor contactknoppen.', 'contactPage')]
final readonly class ContactPage extends AbstractPageComposer {

    protected function taxonomyMap(): TaxonomyMap {
        return TaxonomyMap::CONTACT;
    }

    protected function viewKey(): string {
        return 'contactPage';
    }
}
