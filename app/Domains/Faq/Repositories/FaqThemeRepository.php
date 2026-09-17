<?php declare(strict_types=1);

namespace App\Domains\Faq\Repositories;

use App\Domains\Faq\Contracts\FaqThemeRepositoryInterface;
use App\Domains\Faq\Models\FaqTheme;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final readonly class FaqThemeRepository implements FaqThemeRepositoryInterface {

    public function getForPage(int $pageId): Collection {
        return $this->getBaseQuery()
            ->whereHas('pages', fn(Builder $query) => $query->where('atom_pages.id', $pageId))
            ->orderBy('rg_faq_themes.priority')
            ->get()
            ->filter(fn(FaqTheme $theme) => $theme->faqs->isNotEmpty())
            ->values();
    }

    private function getBaseQuery(): Builder {
        return FaqTheme::query()->published()->with('faqs');
    }

}
