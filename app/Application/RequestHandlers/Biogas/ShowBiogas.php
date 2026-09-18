<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Biogas;

use App\Domains\Article\Contracts\ArticleRepositoryInterface;
use App\Domains\Page\Models\Page;
use BenedenBoven\Atom\Application\Models\Taxonomy;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

final readonly class ShowBiogas {

    /** Het kennisthema waarvan de artikelen onder "Verder lezen" voorgaan. */
    private const THEME = 'Biogas';

    public function __construct(
        private ResponseFactory            $responseFactory,
        private ArticleRepositoryInterface $articleRepository
    ) {}

    public function __invoke(): Response {
        $taxonomy = Taxonomy::getCurrentInstance();

        /** @var Page $page */
        $page = $taxonomy->getModel();
        $page->loadMissing('header');

        return $this->responseFactory->view('biogas.show', [
            'taxonomy' => $taxonomy,
            'page'     => $page,
            'related'  => $this->articleRepository->getForTheme(self::THEME),
        ]);
    }
}
