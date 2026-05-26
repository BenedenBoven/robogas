<?php declare(strict_types=1);

namespace App\Support\Services;

use App\Domains\Page\Models\Page as PageModel;
use BenedenBoven\Atom\Application\Models\Taxonomy;
use BenedenBoven\Atom\Application\QueryBuilders\AtomModelQueryBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class Page {

    public static function getOnPageChildren(Taxonomy $taxonomy, array $types = [PageModel::class]): Collection {
        return $taxonomy->children()->whereHasMorph('model', $types, function(AtomModelQueryBuilder $query) {
            return $query->where('visible_as_page', 0)->published();
        })->with(['model' => function(MorphTo $query) {
            return $query->withGeneralImage();
        }])->get()->sortBy('model.priority');
    }

    public static function getChildren(Taxonomy $taxonomy, array $types = [PageModel::class]): Collection {
        return $taxonomy->children()->whereHasMorph('model', $types, function(AtomModelQueryBuilder $query) {
            return $query->published();
        })
            ->get()
            ->each(
                fn(Taxonomy $taxonomy) => $taxonomy->getModel()->loadMissingGeneralImage()
            )->sortBy('model.priority');
    }

}