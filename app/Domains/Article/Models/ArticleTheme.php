<?php declare(strict_types=1);

namespace App\Domains\Article\Models;

use BenedenBoven\Atom\Application\Models\AtomModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Een thema van Onze kennis, zoals Basiskennis of Installatie. Het filter
 * boven het kennisoverzicht.
 *
 * @property int    $id
 * @property string $title
 * @property int    $priority
 */
final class ArticleTheme extends AtomModel {

    protected       $table                 = 'rg_article_themes';
    protected       $fillable              = ['title'];
    protected       $guarded               = ['_token', '_method'];
    protected       $isPublishable         = true;
    protected bool  $atomSimpleFormView    = true;
    protected array $excludedRelationships = ['articles'];
    protected array $validation            = [
        'title' => 'required',
    ];

    /** Alleen voor het tonen; beheerd vanaf het artikel. */
    public function articles(): HasMany {
        return $this->hasMany(Article::class, 'article_theme_id');
    }
}
