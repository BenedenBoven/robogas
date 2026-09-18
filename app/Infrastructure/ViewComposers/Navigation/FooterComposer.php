<?php declare(strict_types=1);

namespace App\Infrastructure\ViewComposers\Navigation;

use App\Domains\Audience\Contracts\AudienceRepositoryInterface;
use App\Domains\Page\Contracts\PageRepositoryInterface;
use App\Domains\Page\Models\Page;
use App\Domains\Service\Contracts\ServiceRepositoryInterface;
use App\Infrastructure\Attributes\ComposerDescription;
use App\Infrastructure\Attributes\ComposesViews;
use App\Infrastructure\ViewComposers\AbstractMemoizedComposer;
use App\Support\Services\CompanyDetails;
use App\Support\TaxonomyMap;
use Illuminate\Cache\CacheManager;
use Illuminate\Support\Collection;
use Illuminate\View\View;

/**
 * De sitemap in de footer. Diensten en doelgroepen komen uit hun module, de
 * rest zijn vaste pagina's. Een pagina of item dat offline staat, verdwijnt
 * vanzelf uit de footer; een kolom zonder links ook.
 *
 * De labels zijn de paginatitels uit Atom, zodat een hernoemde pagina niet
 * op twee plekken aangepast hoeft te worden.
 */
#[ComposesViews(
    'components.footer'
)]
#[ComposerDescription('De kolommen, de contactpagina en de juridische links in de footer.', 'footerColumns', 'contactPage', 'legalPages')]
final readonly class FooterComposer extends AbstractMemoizedComposer {

    private const ARRANGE = [TaxonomyMap::ORDER, TaxonomyMap::QUOTE, TaxonomyMap::MALFUNCTION];
    private const ABOUT   = [TaxonomyMap::ABOUT, TaxonomyMap::KNOWLEDGE, TaxonomyMap::FAQ, TaxonomyMap::BIOGAS, TaxonomyMap::CONTACT];
    private const LEGAL   = [TaxonomyMap::TERMS, TaxonomyMap::PRIVACY];

    public function __construct(
        CacheManager                        $cacheManager,
        private PageRepositoryInterface     $pageRepository,
        private ServiceRepositoryInterface  $serviceRepository,
        private AudienceRepositoryInterface $audienceRepository,
        private CompanyDetails              $companyDetails
    ) {
        parent::__construct($cacheManager);
    }

    public function compose(View $view): void {
        $pages = $this->memoize('footer_pages', fn() => $this->pageRepository->getByTaxonomyMaps([...self::ARRANGE, ...self::ABOUT, ...self::LEGAL]));

        $arrange = $this->linksTo($pages, self::ARRANGE);

        // Zolang het adres van het portaal onbekend is, gaat de link naar contact.
        if(($portalUrl = $this->companyDetails->portalUrl() ?? $pages->get(TaxonomyMap::CONTACT->value)?->url) !== null) {
            $arrange[] = ['label' => 'Mijn Robogas', 'url' => $portalUrl];
        }

        $columns = array_filter([
            'Diensten'     => $this->memoize('services_all', fn() => $this->serviceRepository->getAll())
                ->map(fn($service) => ['label' => $service->title, 'url' => $service->url])->all(),
            'Voor wie'     => $this->memoize('audiences_all', fn() => $this->audienceRepository->getAll())
                ->map(fn($audience) => ['label' => $audience->title, 'url' => $audience->url])->all(),
            'Regelen'      => $arrange,
            'Over RoboGas' => $this->linksTo($pages, self::ABOUT),
        ]);

        $this->addToViewIfMissing($view, 'footerColumns', $columns);
        $this->addToViewIfMissing($view, 'contactPage', $pages->get(TaxonomyMap::CONTACT->value));
        $this->addToViewIfMissing($view, 'legalPages', $this->linksTo($pages, self::LEGAL));
    }

    /**
     * @param  Collection<int, Page> $pages
     * @param  list<TaxonomyMap>     $maps
     * @return list<array{label: string, url: string}>
     */
    private function linksTo(Collection $pages, array $maps): array {
        return array_values(array_filter(array_map(function(TaxonomyMap $map) use ($pages) {
            $page = $pages->get($map->value);

            return $page ? ['label' => $page->title, 'url' => $page->url] : null;
        }, $maps)));
    }
}
