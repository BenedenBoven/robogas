<?php declare(strict_types=1);

namespace App\Domains\Vacancy\Models;

use BenedenBoven\Atom\Application\Models\AtomModel;

/**
 * Een vacature onder Vacatures.
 *
 * @property int         $id
 * @property string      $title
 * @property string|null $hours
 * @property string|null $location
 * @property string|null $summary
 * @property string|null $body
 * @property int|null    $header_id
 * @property int         $priority
 */
final class Vacancy extends AtomModel {

    protected       $table                 = 'rg_vacancies';
    protected       $fillable              = ['title', 'hours', 'location', 'summary', 'body', 'header_id'];
    protected       $guarded               = ['_token', '_method'];
    protected       $isPublishable         = true;
    protected array $excludedRelationships = [];
    protected array $validation            = [
        'title' => 'required',
    ];

    /** "38 uur · Nijkerk", voor de lijst en de header. Leeg als geen van beide is ingevuld. */
    public function getMetaAttribute(): string {
        return implode(' · ', array_filter([trim((string)$this->hours), trim((string)$this->location)]));
    }
}
