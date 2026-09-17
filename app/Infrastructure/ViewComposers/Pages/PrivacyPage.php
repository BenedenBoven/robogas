<?php declare(strict_types=1);

namespace App\Infrastructure\ViewComposers\Pages;

use App\Infrastructure\Attributes\ComposerDescription;
use App\Infrastructure\Attributes\ComposesViews;
use App\Support\TaxonomyMap;

#[ComposesViews(
    'components.form.privacy'
)]
#[ComposerDescription('De privacyverklaring, voor de link bij het vinkje onder een formulier.', 'privacyPage')]
final readonly class PrivacyPage extends AbstractPageComposer {

    protected function taxonomyMap(): TaxonomyMap {
        return TaxonomyMap::PRIVACY;
    }

    protected function viewKey(): string {
        return 'privacyPage';
    }
}
