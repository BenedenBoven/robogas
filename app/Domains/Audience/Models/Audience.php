<?php declare(strict_types=1);

namespace App\Domains\Audience\Models;

use App\Domains\Service\Models\Service;
use App\Infrastructure\Traits\HasLineLists;
use BenedenBoven\Atom\Application\Models\AtomModel;
use BenedenBoven\Atom\Modules\Media\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Een doelgroep: voor wie RoboGas levert.
 *
 * @property int         $id
 * @property string      $title
 * @property string|null $long_title  valt via Atom terug op title
 * @property string      $icon
 * @property string|null $summary
 * @property string|null $benefits    één punt per regel
 * @property string|null $uses        één punt per regel
 * @property string|null $body
 * @property int|null    $header_id
 * @property int         $priority
 */
final class Audience extends AtomModel {

    use HasLineLists;

    protected       $table         = 'rg_audiences';
    protected       $fillable      = ['title', 'long_title', 'icon', 'summary', 'benefits', 'uses', 'body', 'header_id'];
    protected       $guarded       = ['_token', '_method'];
    protected       $isPublishable = true;
    protected array $excludedRelationships = [];
    protected array $validation    = [
        'title' => 'required',
        'icon'  => 'required',
    ];

    /**
     * Zonder image_id in $fillable geeft Atom geen images(); het beeld naast de
     * leeskolom komt uit dit tabblad.
     */
    public function images(): MorphMany {
        return $this->morphMany(Media::class, 'model')->where('type', 'image')->orderBy('prio');
    }

    public function services(): BelongsToMany {
        return $this->belongsToMany(Service::class, 'rg_audiences_services', 'audience_id', 'service_id')
            ->withTimestamps()->published()->joined()->orderBy('rg_services.priority');
    }

    /** Het svg-bestand voor Vite::asset(). */
    public function getIconAssetAttribute(): string {
        return 'resources/img/icon-' . $this->icon . '.svg';
    }

    /** @return list<string> */
    public function getBenefitItemsAttribute(): array {
        return $this->linesOf('benefits');
    }

    /** @return list<string> */
    public function getUseItemsAttribute(): array {
        return $this->linesOf('uses');
    }
}
