<?php declare(strict_types=1);

namespace App\Domains\Faq\Models;

use App\Domains\Page\Models\Page;
use BenedenBoven\Atom\Application\Models\AtomModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Een thema van veelgestelde vragen, zoals Bestellen of Veiligheid en storingen.
 *
 * @property int    $id
 * @property string $title
 * @property int    $priority
 */
final class FaqTheme extends AtomModel {

    protected       $table              = 'rg_faq_themes';
    protected       $fillable           = ['title'];
    protected       $guarded            = ['_token', '_method'];
    protected       $isPublishable      = true;
    protected bool  $atomSimpleFormView = true;
    protected array $validation         = [
        'title' => 'required',
    ];

    /** Alleen voor het tonen; beheerd vanaf de vraag. */
    protected array $excludedRelationships = ['faqs'];

    public function faqs(): HasMany {
        return $this->hasMany(Faq::class, 'faq_theme_id')->published()->orderBy('rg_faqs.priority');
    }

    /** De pagina's waarop dit thema onder het formulier staat. */
    public function pages(): BelongsToMany {
        return $this->belongsToMany(Page::class, 'rg_faq_themes_pages', 'faq_theme_id', 'page_id')->withTimestamps()->joined();
    }
}
