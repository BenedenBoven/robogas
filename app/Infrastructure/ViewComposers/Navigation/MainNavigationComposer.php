<?php declare(strict_types=1);

namespace App\Infrastructure\ViewComposers\Navigation;

use App\Domains\Audience\Contracts\AudienceRepositoryInterface;
use App\Domains\Page\Contracts\PageRepositoryInterface;
use App\Domains\Vacancy\Contracts\VacancyRepositoryInterface;
use App\Infrastructure\Attributes\ComposerDescription;
use App\Infrastructure\Attributes\ComposesViews;
use App\Infrastructure\ViewComposers\AbstractMemoizedComposer;
use App\Support\Services\CompanyDetails;
use App\Support\TaxonomyMap;
use BenedenBoven\Atom\Modules\Navigation\Contracts\NavigationInterface;
use Illuminate\Cache\CacheManager;
use Illuminate\View\View;

/**
 * Het hoofdmenu uit het Atom-menu "default", met de uitklap onder Gastanks.
 *
 * Alleen Gastanks klapt uit, zoals in het ontwerp. De uitklap volgt de pagina:
 * zet de redactie Gastanks elders in het menu, dan verhuist de uitklap mee.
 * De lijst rechts in de uitklap is het Atom-menu "uitgelicht", zodat de
 * redactie zelf bepaalt waar die links heen gaan.
 */
#[ComposesViews(
    'components.nav'
)]
#[ComposerDescription('Het hoofdmenu, de uitklap onder Gastanks, de bestelpagina, het portaal en de taalkeuze.', 'navigationItems', 'megaMenus', 'orderPage', 'portalUrl', 'navCounts', 'languageLinks')]
final readonly class MainNavigationComposer extends AbstractMemoizedComposer {

    /** Hoeveel sectoren er in de uitklap staan; de rest zit achter "Alle sectoren". */
    private const AUDIENCES_IN_MENU = 4;

    public function __construct(
        CacheManager                        $cacheManager,
        private NavigationInterface         $navigationRepository,
        private PageRepositoryInterface     $pageRepository,
        private AudienceRepositoryInterface $audienceRepository,
        private CompanyDetails              $companyDetails,
        private VacancyRepositoryInterface  $vacancyRepository
    ) {
        parent::__construct($cacheManager);
    }

    public function compose(View $view): void {
        $pages = $this->memoize(
            'navigation_pages',
            fn() => $this->pageRepository->getByTaxonomyMaps([TaxonomyMap::ORDER, TaxonomyMap::CONTACT, TaxonomyMap::AUDIENCES, TaxonomyMap::GERMAN])
        );

        $audiences = $this->memoize('audiences_all', fn() => $this->audienceRepository->getAll());
        // Het beeld in de uitklap: zelf laden, want lazy loading staat uit.
        $gastanks = $pages->get(TaxonomyMap::AUDIENCES->value)?->loadMissing('header');

        $view->with([
            'navigationItems' => $this->memoize('navigation_default', fn() => $this->navigationRepository->optimizedBySlug('default')),
            'megaMenus'       => [
                TaxonomyMap::AUDIENCES->value => [
                    'heading'   => 'Bestel voor…',
                    'eyebrow'   => 'Gas voor grootgebruik',
                    'media'     => $gastanks?->header,
                    'links'     => $audiences->take(self::AUDIENCES_IN_MENU)
                        ->map(fn($audience) => ['label' => $audience->title, 'url' => $audience->url, 'summary' => $audience->summary])->values()->all(),
                    'allLabel'  => 'Alle sectoren',
                    'allUrl'    => $gastanks?->url,
                    'highlight' => $this->memoize('navigation_uitgelicht', fn() => $this->navigationRepository->optimizedBySlug('uitgelicht'))
                        ->map(fn($item) => ['label' => $item->title, 'url' => $item->url])->all(),
                ],
            ],
            'orderPage'       => $pages->get(TaxonomyMap::ORDER->value),
            // Teller achter een menu-item, per taxonomy-id. Nul toont geen teller.
            'navCounts'       => [TaxonomyMap::CAREERS->value => $this->memoize('vacancy_count', fn() => $this->vacancyRepository->count())],
            // Zolang het adres van het portaal onbekend is, gaat het tabje naar contact.
            'portalUrl'       => $this->companyDetails->portalUrl() ?? $pages->get(TaxonomyMap::CONTACT->value)?->url,
            // Eén Duitse pagina, geen tweede taal in Atom: NL is de site zelf.
            'languageLinks'   => array_values(array_filter([
                ['label' => 'NL', 'url' => '/'],
                ($german = $pages->get(TaxonomyMap::GERMAN->value)) ? ['label' => 'DE', 'url' => $german->url] : null,
            ])),
        ]);
    }
}
