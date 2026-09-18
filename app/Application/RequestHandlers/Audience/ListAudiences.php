<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Audience;

use App\Domains\Audience\Contracts\AudienceRepositoryInterface;
use App\Domains\Page\Models\Page;
use BenedenBoven\Atom\Application\Models\Taxonomy;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

final readonly class ListAudiences {

    public function __construct(
        private ResponseFactory             $responseFactory,
        private AudienceRepositoryInterface $audienceRepository
    ) {}

    public function __invoke(): Response {
        $taxonomy = Taxonomy::getCurrentInstance();

        /** @var Page $page */
        $page = $taxonomy->getModel();
        $page->loadMissing(['header', 'images']);

        return $this->responseFactory->view('audiences.list', [
            'taxonomy'  => $taxonomy,
            'page'      => $page,
            // De foto op de kaart; alleen hier nodig, dus niet in de repository.
            'audiences' => $this->audienceRepository->getAll()->loadMissing('header'),
        ]);
    }
}
