<?php declare(strict_types=1);

namespace App\Domains\Service\Models;

use BenedenBoven\Atom\Application\Models\AtomModel;

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
    protected array $validation    = [
        'title' => 'required',
        'icon'  => 'required',
    ];

    public function getIconClassAttribute(): string {
        return self::ICONS[$this->icon] ?? reset(self::ICONS);
    }

    /** @return list<string> */
    public function getWeDoItemsAttribute(): array {
        return self::lines($this->we_do);
    }

    /** @return list<string> */
    public function getWeNeedItemsAttribute(): array {
        return self::lines($this->we_need);
    }

    /** @return list<string> */
    private static function lines(?string $text): array {
        return array_values(array_filter(array_map('trim', preg_split('/\R/', (string)$text))));
    }
}
