<?php declare(strict_types=1);

namespace App\Application\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class CacheResponse {
    public function __construct(
        private Cache $cache,
        private Auth  $auth,
    ) {}

    public function handle(Request $request, Closure $next): Response {
        if($this->auth->check() || !app()->isProduction()) {
            return $next($request);
        }

        $cacheKey = 'page_' . sha1($request->fullUrl());

        if($this->cache->has($cacheKey)) {
            $cached = $this->cache->get($cacheKey);

            return response($cached['content'])
                ->withHeaders($cached['headers']);
        }

        $response = $next($request);

        if($request->isMethod('GET') && $response->status() === Response::HTTP_OK) {
            $this->cache->put(
                $cacheKey,
                [
                    'content' => $response->getContent(),
                    'headers' => $response->headers->all(),
                ],
                now()->addMinutes(5)
            );
        }

        return $response;
    }
}