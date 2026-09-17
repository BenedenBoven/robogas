<?php declare(strict_types=1);

namespace App\Domains\Faq\Models;

use BenedenBoven\Atom\Application\Models\AtomModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Een veelgestelde vraag. De vraag staat in title, het antwoord in body.
 *
 * @property int         $id
 * @property int         $faq_theme_id
 * @property string      $title
 * @property string|null $body
 * @property int         $priority
 */
final class Faq extends AtomModel {

    protected       $table          = 'rg_faqs';
    protected       $fillable       = ['title', 'body'];
    protected       $guarded        = ['_token', '_method'];
    protected       $isPublishable  = true;
    protected array $excludedRelationships = [];
    protected array $validation     = [
        'title'              => 'required',
        'body'               => 'required',
        'relationship.theme' => 'required',
    ];
    protected array $overviewFields = [
        [
            'attribute'    => 'themeTitle',
            'attribute_as' => 'faq_theme_id',
            'title'        => 'Thema',
            'orderable'    => true,
            'visible'      => true,
            'searchable'   => false,
        ],
    ];
    protected array $loadRelationshipsInAtom = ['theme'];

    public function theme(): BelongsTo {
        return $this->belongsTo(FaqTheme::class, 'faq_theme_id');
    }

    public function getThemeTitleAttribute(): string {
        return (string)$this->theme?->title;
    }
}
