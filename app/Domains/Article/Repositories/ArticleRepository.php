<?php declare(strict_types=1);

namespace App\Domains\Article\Repositories;

use App\Domains\Article\Contracts\ArticleRepositoryInterface;
use App\Domains\Article\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final readonly class ArticleRepository implements ArticleRepositoryInterface {

    public function getAll(): Collection {
        return $this->getBaseQuery()->get();
    }

    public function getRelated(Article $article, int $limit = 3): Collection {
        $audienceIds = $article->audiences->pluck('id')->all();

        return $this->getBaseQuery()
            ->where('rg_articles.id', '!=', $article->id)
            ->get()
            ->sortBy(fn(Article $other) => match (true) {
                $other->article_theme_id !== null && $other->article_theme_id === $article->article_theme_id => 0,
                $other->audiences->pluck('id')->intersect($audienceIds)->isNotEmpty()                          => 1,
                default                                                                                         => 2,
            })
            ->take($limit)
            ->values();
    }

    public function getForTheme(string $themeTitle, int $limit = 3): Collection {
        return $this->getBaseQuery()
            ->get()
            ->sortBy(fn(Article $article) => $article->theme?->title === $themeTitle ? 0 : 1)
            ->take($limit)
            ->values();
    }

    public function getFirst(int $limit): Collection {
        return $this->getBaseQuery()->limit($limit)->get();
    }

    private function getBaseQuery(): Builder {
        return Article::query()->published()->joined()
            ->with(['theme', 'audiences', 'header'])
            ->orderBy('rg_articles.priority');
    }

}
