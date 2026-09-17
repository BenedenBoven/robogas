<?php declare(strict_types=1);

namespace App\Infrastructure\ViewComposers\Collections;

use App\Domains\Audience\Contracts\AudienceRepositoryInterface;
use App\Infrastructure\Attributes\ComposerDescription;
use App\Infrastructure\Attributes\ComposesViews;
use App\Infrastructure\ViewComposers\AbstractMemoizedComposer;
use Illuminate\Cache\CacheManager;
use Illuminate\View\View;

#[ComposesViews(
    'components.services'
)]
#[ComposerDescription('De gepubliceerde doelgroepen voor het iconenblok op de homepage.', 'audiences')]
final readonly class AudiencesComposer extends AbstractMemoizedComposer {

    public function __construct(
        CacheManager                        $cacheManager,
        private AudienceRepositoryInterface $audienceRepository
    ) {
        parent::__construct($cacheManager);
    }

    public function compose(View $view): void {
        $audiences = $this->memoize('audiences_all', fn() => $this->audienceRepository->getAll());

        $this->addToViewIfMissing($view, 'audiences', $audiences);
    }
}
