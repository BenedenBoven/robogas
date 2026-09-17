<?php declare(strict_types=1);

namespace App\Domains\Service\Models;

use App\Domains\Audience\Models\Audience;
use App\Infrastructure\Traits\HasLineLists;
use BenedenBoven\Atom\Application\Models\AtomModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Een stap uit de A-tot-Z aanpak.
 *
 * @property int         $id
 * @property string      $title
 * @property string      $icon
 * @property string|null $summary
 * @property string|null $body
 * @property string|null $we_do    één punt per regel
 * @property string|null $we_need  één punt per regel
 * @property int|null    $header_id
 * @property int         $priority
 */
final class Service extends AtomModel {

    use HasLineLists;

    public const ICONS = [
        'advies'      => 'fa-solid fa-comments',
        'planvorming' => 'fa-solid fa-ruler-combined',
        'installatie' => 'fa-solid fa-screwdriver-wrench',
        'levering'    => 'fa-solid fa-truck-droplet',
        'service'     => 'fa-solid fa-headset',
    ];

    protected       $table         = 'rg_services';
    protected       $fillable      = ['title', 'icon', 'summary', 'body', 'we_do', 'we_need', 'header_id'];
    protected       $guarded       = ['_token', '_method'];
    protected       $isPublishable = true;
    protected array $excludedRelationships = [];
    protected array $validation    = [
        'title' => 'required',
        'icon'  => 'required',
    ];

    /** Dezelfde koppeltabel als Audience::services(); te beheren vanaf beide kanten. */
    public function audiences(): BelongsToMany {
        return $this->belongsToMany(Audience::class, 'rg_audiences_services', 'service_id', 'audience_id')
            ->withTimestamps()->published()->joined()->orderBy('rg_audiences.priority');
    }

    public function getIconClassAttribute(): string {
        return self::ICONS[$this->icon] ?? reset(self::ICONS);
    }

    /** @return list<string> */
    public function getWeDoItemsAttribute(): array {
        return $this->linesOf('we_do');
    }

    /** @return list<string> */
    public function getWeNeedItemsAttribute(): array {
        return $this->linesOf('we_need');
    }
}
