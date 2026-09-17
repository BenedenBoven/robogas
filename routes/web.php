<?php declare(strict_types=1);

use App\Application\RequestHandlers\Default\ShowDefault;
use App\Application\RequestHandlers\Home\ShowHome;
use App\Application\RequestHandlers\Service\ListServices;
use App\Application\RequestHandlers\Service\ShowService;
use App\Domains\Service\Models\Service;
use App\Support\TaxonomyMap;
use BenedenBoven\Atom\Application\RequestHandlers\ResizeController;
use BenedenBoven\Atom\Application\Services\TaxonomyDiscoverer;
use Illuminate\Routing\Router;

/** @var Router $router */
$router->get('/uploads/media/cache/{file}', ResizeController::class);

$taxonomy = TaxonomyDiscoverer::getCurrentInstance();

if($taxonomy !== null) {

    $specific = match ($taxonomy->id) {
        TaxonomyMap::HOME->value     => $router->get($taxonomy->url, ShowHome::class),
        TaxonomyMap::SERVICES->value => $router->get($taxonomy->url, ListServices::class),
        default                      => null
    };

    if($specific === null) {
        match (get_class($taxonomy->getModel())) {
            Service::class => $router->any('{all}', ShowService::class)->where('all', '.*'),
            default        => $router->any('{all}', ShowDefault::class)->where('all', '.*')
        };
    }
}
