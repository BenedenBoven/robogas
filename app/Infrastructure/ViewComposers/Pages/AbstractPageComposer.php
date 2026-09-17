<?php declare(strict_types=1);

namespace App\Infrastructure\ViewComposers\Pages;

use App\Domains\Page\Contracts\PageRepositoryInterface;
use App\Infrastructure\ViewComposers\AbstractMemoizedComposer;
use App\Support\TaxonomyMap;
use Illuminate\Cache\CacheManager;
use Illuminate\View\View;

/**
 * Basis voor de page composers die een vaste pagina uit de TaxonomyMap
 * beschikbaar maken als linkbestemming. Zo staat er geen hardcoded pad in Blade.
 *
 * Abstract en zonder #[ComposesViews], dus de ComposerServiceProvider slaat
 * deze klasse over.
 */
abstract readonly class AbstractPageComposer extends AbstractMemoizedComposer {

    public function __construct(
        CacheManager                    $cacheManager,
        private PageRepositoryInterface $pageRepository
    ) {
        parent::__construct($cacheManager);
    }

    abstract protected function taxonomyMap(): TaxonomyMap;

    abstract protected function viewKey(): string;

    public function compose(View $view): void {
        $map = $this->taxonomyMap();

        $page = $this->memoize(
            'page_' . $map->name,
            fn() => $this->pageRepository->getByTaxonomyMap($map)
        );

        $this->addToViewIfMissing($view, $this->viewKey(), $page);
    }
}
