<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Knowledge;

use App\Domains\Article\Contracts\ArticleRepositoryInterface;
use App\Domains\Article\Models\Article;
use BenedenBoven\Atom\Application\Models\Taxonomy;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

final readonly class ShowArticle {

    public function __construct(
        private ResponseFactory            $responseFactory,
        private ArticleRepositoryInterface $articleRepository
    ) {}

    public function __invoke(): Response {
        $taxonomy = Taxonomy::getCurrentInstance();

        /** @var Article $article */
        $article = $taxonomy->getModel();
        $article->loadMissing(['header', 'theme', 'audiences']);

        return $this->responseFactory->view('knowledge.show', [
            'taxonomy' => $taxonomy,
            'article'  => $article,
            'related'  => $this->articleRepository->getRelated($article),
        ]);
    }
}
