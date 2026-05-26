<?php declare(strict_types=1);

namespace App\Infrastructure\ViewComposers;

use Illuminate\Cache\CacheManager;
use Illuminate\View\View;

abstract readonly class AbstractMemoizedComposer {

    public function __construct(
        protected CacheManager $cacheManager
    ) {}

    /**
     * Memoize a value for the duration of the request
     */
    protected function memoize(string $key, callable $callback): mixed {
        $memoCache = $this->cacheManager->memo();

        $value = $memoCache->get($key);

        if($value === null) {
            $value = $callback();
            $memoCache->put($key, $value, 1);
        }

        return $value;
    }

    /**
     * Add data to view only if it doesn't already exist
     */
    protected function addToViewIfMissing(View $view, string $key, mixed $value): void {
        if(!$view->offsetExists($key)) {
            $view->with($key, $value);
        }
    }

    abstract public function compose(View $view): void;
}