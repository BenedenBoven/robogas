<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\About;

use App\Domains\Page\Models\Page;
use BenedenBoven\Atom\Application\Models\Taxonomy;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

final readonly class ShowAbout {

    public function __construct(
        private ResponseFactory $responseFactory
    ) {}

    public function __invoke(): Response {
        $taxonomy = Taxonomy::getCurrentInstance();

        /** @var Page $page */
        $page = $taxonomy->getModel();
        $page->loadMissing(['header', 'images', 'facts', 'milestones']);

        return $this->responseFactory->view('about.show', [
            'taxonomy' => $taxonomy,
            'page'     => $page,
        ]);
    }
}
