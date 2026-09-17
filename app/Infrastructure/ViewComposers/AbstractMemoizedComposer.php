<?php declare(strict_types=1);

namespace App\Infrastructure\ViewComposers;

use Illuminate\Cache\CacheManager;
use Illuminate\View\View;

abstract readonly class AbstractMemoizedComposer {

    public function __construct(
        protected CacheManager $cacheManager
    ) {}

    /**
     * Memoize a value for the duration of the request.
     *
     * Bewust over de array-store: memo() wikkelt anders de standaardstore, en
     * die schrijft naar bestand of redis. De waarde blijft dan een seconde
     * staan en wordt door een volgend request meegelezen.
     */
    protected function memoize(string $key, callable $callback): mixed {
        $memoCache = $this->cacheManager->memo('array');

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