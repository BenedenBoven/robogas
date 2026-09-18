<?php declare(strict_types=1);

namespace App\Domains\Article\Contracts;

use App\Domains\Article\Models\Article;
use Illuminate\Support\Collection;

interface ArticleRepositoryInterface {

    /**
     * Alle gepubliceerde artikelen in de volgorde uit het beheer, met thema,
     * labels en headerbeeld voor de kaart.
     *
     * @return Collection<int, Article>
     */
    public function getAll(): Collection;

    /**
     * Artikelen die bij dit artikel passen: eerst hetzelfde thema, dan een
     * gedeelde doelgroep, dan de rest. Nooit het artikel zelf.
     *
     * @return Collection<int, Article>
     */
    public function getRelated(Article $article, int $limit = 3): Collection;

    /**
     * Artikelen voor een pagina over één onderwerp: eerst die uit het thema met
     * deze titel, aangevuld met de eerste andere. Bestaat het thema niet (meer),
     * dan gewoon de eerste artikelen.
     *
     * @return Collection<int, Article>
     */
    public function getForTheme(string $themeTitle, int $limit = 3): Collection;

    /**
     * De eerste artikelen uit het beheer, voor een blok op een andere pagina.
     *
     * @return Collection<int, Article>
     */
    public function getFirst(int $limit): Collection;

}
