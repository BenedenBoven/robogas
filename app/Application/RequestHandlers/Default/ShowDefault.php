<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Default;

use App\Domains\Page\Models\Page;
use BenedenBoven\Atom\Application\Models\Taxonomy;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

/**
 * Elke pagina zonder eigen handler: de juridische teksten en losse pagina's
 * die de redactie zelf aanmaakt.
 */
final readonly class ShowDefault {

    public function __construct(
        private ResponseFactory $responseFactory
    ) {}

    public function __invoke(): Response {
        $taxonomy = Taxonomy::getCurrentInstance();
        $page     = $taxonomy->getModel();

        // Een ander model zonder eigen handler heeft mogelijk geen header of beelden.
        if($page instanceof Page) {
            $page->loadMissing(['header', 'images']);
        }

        return $this->responseFactory->view('default.show', [
            'taxonomy' => $taxonomy,
            'page'     => $page,
        ]);
    }
}
