<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Knowledge;

use App\Domains\Article\Contracts\ArticleRepositoryInterface;
use App\Domains\Article\Models\Article;
use App\Domains\Page\Models\Page;
use BenedenBoven\Atom\Application\Models\Taxonomy;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

final readonly class ListArticles {

    public function __construct(
        private ResponseFactory            $responseFactory,
        private ArticleRepositoryInterface $articleRepository
    ) {}

    /**
     * De themafilters komen uit de artikelen zelf: een thema zonder artikelen
     * geeft een knop die niets toont.
     */
    public function __invoke(): Response {
        $taxonomy = Taxonomy::getCurrentInstance();

        /** @var Page $page */
        $page     = $taxonomy->getModel();
        $articles = $this->articleRepository->getAll();

        return $this->responseFactory->view('knowledge.list', [
            'taxonomy' => $taxonomy,
            'page'     => $page,
            'articles' => $articles,
            'themes'   => $articles->map(fn(Article $article) => $article->theme)->filter()->unique('id')->sortBy('priority')->values(),
        ]);
    }
}
