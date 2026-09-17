<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Audience;

use App\Domains\Audience\Models\Audience;
use App\Domains\Service\Contracts\ServiceRepositoryInterface;
use BenedenBoven\Atom\Application\Models\Taxonomy;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

final readonly class ShowAudience {

    public function __construct(
        private ResponseFactory            $responseFactory,
        private ServiceRepositoryInterface $serviceRepository
    ) {}

    /**
     * Het stappenlint onderaan toont altijd de hele aanpak, niet alleen de
     * gekoppelde diensten: het laat zien hoe het werkt, niet wat er geleverd wordt.
     */
    public function __invoke(): Response {
        $taxonomy = Taxonomy::getCurrentInstance();

        /** @var Audience $audience */
        $audience = $taxonomy->getModel();
        $audience->loadMissing(['header', 'images']);

        return $this->responseFactory->view('audiences.show', [
            'taxonomy' => $taxonomy,
            'audience' => $audience,
            'services' => $this->serviceRepository->getAll(),
        ]);
    }
}
