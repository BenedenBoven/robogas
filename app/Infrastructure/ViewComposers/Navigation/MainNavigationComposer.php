<?php declare(strict_types=1);

namespace App\Infrastructure\ViewComposers\Navigation;

use App\Domains\Audience\Contracts\AudienceRepositoryInterface;
use App\Domains\Page\Contracts\PageRepositoryInterface;
use App\Domains\Service\Contracts\ServiceRepositoryInterface;
use App\Infrastructure\Attributes\ComposerDescription;
use App\Infrastructure\Attributes\ComposesViews;
use App\Infrastructure\ViewComposers\AbstractMemoizedComposer;
use App\Support\Services\CompanyDetails;
use App\Support\TaxonomyMap;
use BenedenBoven\Atom\Modules\Navigation\Contracts\NavigationInterface;
use Illuminate\Cache\CacheManager;
use Illuminate\View\View;

/**
 * Het hoofdmenu uit het Atom-menu "default", met het mega-menu eronder.
 *
 * Welke items een mega-menu krijgen, volgt uit waar ze naar wijzen: het
 * overzicht van Diensten of Doelgroepen. Zet de redactie die pagina's elders in
 * het menu, dan verhuist het mega-menu mee.
 */
#[ComposesViews(
    'components.nav'
)]
#[ComposerDescription('Het hoofdmenu, de mega-menu\'s per item, de acties onder "Direct regelen", de bestelpagina en het portaal.', 'navigationItems', 'megaMenus', 'arrangeLinks', 'orderPage', 'portalUrl')]
final readonly class MainNavigationComposer extends AbstractMemoizedComposer {

    private const ARRANGE = [TaxonomyMap::QUOTE, TaxonomyMap::ORDER, TaxonomyMap::MALFUNCTION];

    public function __construct(
        CacheManager                        $cacheManager,
        private NavigationInterface         $navigationRepository,
        private PageRepositoryInterface     $pageRepository,
        private ServiceRepositoryInterface  $serviceRepository,
        private AudienceRepositoryInterface $audienceRepository,
        private CompanyDetails              $companyDetails
    ) {
        parent::__construct($cacheManager);
    }

    public function compose(View $view): void {
        $pages = $this->memoize('navigation_pages', fn() => $this->pageRepository->getByTaxonomyMaps([...self::ARRANGE, TaxonomyMap::CONTACT]));

        $view->with([
            'navigationItems' => $this->memoize('navigation_default', fn() => $this->navigationRepository->optimizedBySlug('default')),
            'megaMenus'       => [
                TaxonomyMap::SERVICES->value  => [
                    'heading' => 'A-tot-Z aanpak',
                    'links'   => $this->memoize('services_all', fn() => $this->serviceRepository->getAll())
                        ->map(fn($service) => ['label' => $service->title, 'url' => $service->url])->all(),
                ],
                TaxonomyMap::AUDIENCES->value => [
                    'heading' => 'Voor wie',
                    // Labeltje dat bij hover boven de knop verschijnt: "Gas voor Particulier".
                    'badge'   => 'Gas voor',
                    'links'   => $this->memoize('audiences_all', fn() => $this->audienceRepository->getAll())
                        ->map(fn($audience) => ['label' => $audience->title, 'url' => $audience->url])->all(),
                ],
            ],
            'arrangeLinks'    => array_values(array_filter(array_map(
                fn(TaxonomyMap $map) => ($page = $pages->get($map->value)) ? ['label' => $page->title, 'url' => $page->url] : null,
                self::ARRANGE
            ))),
            'orderPage'       => $pages->get(TaxonomyMap::ORDER->value),
            // Zolang het adres van het portaal onbekend is, gaat het tabje naar contact.
            'portalUrl'       => $this->companyDetails->portalUrl() ?? $pages->get(TaxonomyMap::CONTACT->value)?->url,
        ]);
    }
}
