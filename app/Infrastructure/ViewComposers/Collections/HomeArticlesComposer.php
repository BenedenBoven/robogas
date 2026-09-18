<?php declare(strict_types=1);

namespace App\Infrastructure\ViewComposers\Collections;

use App\Domains\Article\Contracts\ArticleRepositoryInterface;
use App\Domains\Page\Contracts\PageRepositoryInterface;
use App\Infrastructure\Attributes\ComposerDescription;
use App\Infrastructure\Attributes\ComposesViews;
use App\Infrastructure\ViewComposers\AbstractMemoizedComposer;
use App\Support\TaxonomyMap;
use Illuminate\Cache\CacheManager;
use Illuminate\View\View;

#[ComposesViews(
    'components.knowledge'
)]
#[ComposerDescription('De eerste zes kennisartikelen en de pagina Onze kennis, voor het kennisblok op de homepage.', 'homeArticles', 'knowledgePage')]
final readonly class HomeArticlesComposer extends AbstractMemoizedComposer {

    private const LIMIT = 6;

    public function __construct(
        CacheManager                       $cacheManager,
        private ArticleRepositoryInterface $articleRepository,
        private PageRepositoryInterface    $pageRepository
    ) {
        parent::__construct($cacheManager);
    }

    public function compose(View $view): void {
        $this->addToViewIfMissing($view, 'homeArticles', $this->memoize('home_articles', fn() => $this->articleRepository->getFirst(self::LIMIT)));
        $this->addToViewIfMissing($view, 'knowledgePage', $this->memoize('page_KNOWLEDGE', fn() => $this->pageRepository->getByTaxonomyMap(TaxonomyMap::KNOWLEDGE)));
    }
}
