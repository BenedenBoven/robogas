<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Service;

use App\Domains\Service\Contracts\ServiceRepositoryInterface;
use App\Domains\Service\Models\Service;
use BenedenBoven\Atom\Application\Models\Taxonomy;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

final readonly class ShowService {

    public function __construct(
        private ResponseFactory            $responseFactory,
        private ServiceRepositoryInterface $serviceRepository
    ) {}

    /**
     * Het stapnummer en de vorige en volgende stap volgen uit de positie in de
     * gepubliceerde lijst, niet uit priority: die kan gaten hebben.
     */
    public function __invoke(): Response {
        $taxonomy = Taxonomy::getCurrentInstance();

        /** @var Service $service */
        $service = $taxonomy->getModel();
        $service->loadMissing('header');

        $services = $this->serviceRepository->getAll();
        $index    = $services->search(fn(Service $step) => $step->id === $service->id);

        return $this->responseFactory->view('services.show', [
            'taxonomy'     => $taxonomy,
            'service'      => $service,
            'services'     => $services,
            'stepNumber'   => $index === false ? null : $index + 1,
            'previousStep' => $index === false ? null : $services->get($index - 1),
            'nextStep'     => $index === false ? null : $services->get($index + 1),
        ]);
    }
}
