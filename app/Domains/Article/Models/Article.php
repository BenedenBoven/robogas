<?php declare(strict_types=1);

namespace App\Domains\Article\Models;

use App\Domains\Audience\Models\Audience;
use BenedenBoven\Atom\Application\Models\AtomModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Een kennisartikel uit Onze kennis.
 *
 * @property int         $id
 * @property int|null    $article_theme_id
 * @property string      $title
 * @property string|null $summary
 * @property string|null $body
 * @property int|null    $header_id
 * @property string      $color     kaartkleur zonder headerbeeld
 * @property int         $priority
 */
final class Article extends AtomModel {

    /** Kaartkleur zonder foto: sleutel in het beheer => grond en inkt op de site. */
    public const COLORS = [
        'blauw' => ['ground' => 'bg-blue group-hover:bg-blue-700', 'ink' => 'text-white', 'tag' => 'bg-yellow text-black'],
        'geel'  => ['ground' => 'bg-yellow group-hover:bg-yellow-400', 'ink' => 'text-black', 'tag' => 'bg-black text-white'],
        'navy'  => ['ground' => 'bg-black group-hover:bg-black-900', 'ink' => 'text-white', 'tag' => 'bg-yellow text-black'],
    ];

    protected       $table                 = 'rg_articles';
    protected       $fillable              = ['title', 'summary', 'body', 'header_id', 'color'];
    protected       $guarded               = ['_token', '_method'];
    protected       $isPublishable         = true;
    protected array $excludedRelationships = [];
    protected array $validation            = [
        'title'              => 'required',
        'relationship.theme' => 'required',
    ];
    protected array $overviewFields = [
        [
            'attribute'    => 'themeTitle',
            'attribute_as' => 'article_theme_id',
            'title'        => 'Thema',
            'orderable'    => true,
            'visible'      => true,
            'searchable'   => false,
        ],
    ];
    protected array $loadRelationshipsInAtom = ['theme'];

    public function theme(): BelongsTo {
        return $this->belongsTo(ArticleTheme::class, 'article_theme_id');
    }

    /** De labels op het artikel: de doelgroepen uit Voor wie. */
    public function audiences(): BelongsToMany {
        return $this->belongsToMany(Audience::class, 'rg_articles_audiences', 'article_id', 'audience_id')
            ->withTimestamps()->published()->joined()->orderBy('rg_audiences.priority');
    }

    public function getThemeTitleAttribute(): string {
        return (string)$this->theme?->title;
    }

    /** @return array{ground: string, ink: string, tag: string} */
    public function getCardColorsAttribute(): array {
        return self::COLORS[$this->color] ?? self::COLORS['blauw'];
    }
}
