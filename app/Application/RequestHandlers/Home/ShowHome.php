<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Home;

use BenedenBoven\Atom\Application\Models\Taxonomy;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

final readonly class ShowHome {

    public function __construct(
        private ResponseFactory $responseFactory
    ) {}

    public function __invoke(): Response {
        $taxonomy = Taxonomy::getCurrentInstance();

        return $this->responseFactory->view('home.show', [
            'taxonomy' => $taxonomy
        ]);
    }
}
