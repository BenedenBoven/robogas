<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Service;

use App\Domains\Page\Models\Page;
use App\Domains\Service\Contracts\ServiceRepositoryInterface;
use BenedenBoven\Atom\Application\Models\Taxonomy;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

final readonly class ListServices {

    public function __construct(
        private ResponseFactory            $responseFactory,
        private ServiceRepositoryInterface $serviceRepository
    ) {}

    public function __invoke(): Response {
        $taxonomy = Taxonomy::getCurrentInstance();

        /** @var Page $page */
        $page = $taxonomy->getModel();
        $page->loadMissing('header');

        return $this->responseFactory->view('services.list', [
            'taxonomy' => $taxonomy,
            'page'     => $page,
            'services' => $this->serviceRepository->getAll(),
        ]);
    }
}
