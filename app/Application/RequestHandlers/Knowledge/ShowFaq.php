<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Knowledge;

use App\Domains\Faq\Contracts\FaqThemeRepositoryInterface;
use App\Domains\Page\Models\Page;
use BenedenBoven\Atom\Application\Models\Taxonomy;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

final readonly class ShowFaq {

    public function __construct(
        private ResponseFactory             $responseFactory,
        private FaqThemeRepositoryInterface $faqThemeRepository
    ) {}

    public function __invoke(): Response {
        $taxonomy = Taxonomy::getCurrentInstance();

        /** @var Page $page */
        $page = $taxonomy->getModel();

        return $this->responseFactory->view('knowledge.faq', [
            'taxonomy'  => $taxonomy,
            'page'      => $page,
            'faqThemes' => $this->faqThemeRepository->getAll(),
        ]);
    }
}
