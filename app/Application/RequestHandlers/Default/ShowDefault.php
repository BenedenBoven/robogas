<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Default;

use BenedenBoven\Atom\Application\Models\Taxonomy;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

final readonly class ShowDefault {

    public function __construct(
        private ResponseFactory $responseFactory
    ) {}

    public function __invoke(): Response {
        $taxonomy = Taxonomy::getCurrentInstance();

        return $this->responseFactory->view('default.show', [
            'taxonomy' => $taxonomy
        ]);
    }
}
