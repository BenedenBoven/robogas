<?php declare(strict_types=1);

namespace App\Infrastructure\ViewComposers\Navigation;

use App\Infrastructure\ViewComposers\AbstractMemoizedComposer;
use BenedenBoven\Atom\Modules\Navigation\Contracts\NavigationInterface;
use Illuminate\Cache\CacheManager;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\View\View;

final readonly class MainNavigationComposer extends AbstractMemoizedComposer {

    public function __construct(
        CacheManager                $cacheManager,
        private NavigationInterface $navigationRepository,
    ) {
        parent::__construct($cacheManager);
    }

    public function compose(View $view): void {
        $navigationItems = $this->memoize(
            'navigation_default',
            fn() => $this->navigationRepository->optimizedBySlug('default')
        );

        $view->with('navigationItems', $navigationItems);
    }
}