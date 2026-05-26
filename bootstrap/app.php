<?php declare(strict_types=1);

use App\Support\TaxonomyMap;
use BenedenBoven\Atom\Application\Models\Taxonomy;
use BenedenBoven\Atom\Modules\Auth\Middleware\AdminRedirectIfNotAuthenticated;
use BenedenBoven\Atom\Modules\Redirect\Models\Redirect;
use BenedenBoven\Atom\Modules\User\Middleware\HasAccess;
use Illuminate\Container\Container;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Sentry\Laravel\Integration;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->booting(function(Application $app) {
        if($app->environment('local')) {
            $app->register(\App\Application\Providers\ClockworkServiceProvider::class);
        }

        $app->register(\BenedenBoven\Atom\Providers\TaxonomyInstanceServiceProvider::class);
    })
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function(Middleware $middleware) {
        $middleware->use([
            // \Illuminate\Http\Middleware\TrustHosts::class,
            TrustProxies::class,
            HandleCors::class,
            PreventRequestsDuringMaintenance::class,
            ValidatePostSize::class,
            TrimStrings::class,
            ConvertEmptyStringsToNull::class,
            InvokeDeferredCallbacks::class,
        ]);

        $middleware->validateCsrfTokens([
            'api/webhooks/*'
        ]);

        $middleware->alias([
            'auth'      => AdminRedirectIfNotAuthenticated::class,
            'hasaccess' => HasAccess::class,
        ]);
    })
    ->withExceptions(function(Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function(Request $request, Throwable $e) {
            if($request->is('api/webhooks/*')) {
                return true;
            }

            return $request->expectsJson();
        });

        if(app()->isProduction()) {
            Integration::handles($exceptions);
        }

        $exceptions->render(function(NotFoundHttpException $e, Request $request) {
            // Check for redirects first.
            if(class_exists(Redirect::class)) {
                $url      = ($request->path() === '/') ? '/' : '/' . $request->path();
                $redirect = Redirect::query()->where('from', $url)->first();

                // Redirect the redirect.
                if(!empty($redirect)) {
                    return app()->make(Redirector::class)->to((string)$redirect->to);
                }
            }

            $taxonomy = Taxonomy::with('model')->find(TaxonomyMap::NOT_FOUND->value);
            Container::getInstance()->instance('taxonomy', $taxonomy);

            return \response()->view('default.show', [
                'taxonomy' => $taxonomy
            ], 404);
        });
    })->create();
