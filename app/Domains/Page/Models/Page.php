<?php declare(strict_types=1);

namespace App\Domains\Page\Models;

use App\Support\TaxonomyMap;
use BenedenBoven\Atom\Application\Models\Page as AtomPage;
use BenedenBoven\Atom\Modules\Media\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property string      $title
 * @property string|null $long_title
 * @property string|null $subtitle        kicker in de paginaheader
 * @property string|null $summary         intro in de paginaheader
 * @property string|null $body
 * @property string|null $block_title
 * @property string|null $block_subtitle
 * @property string|null $block_content
 */
final class Page extends AtomPage {


    protected       $fillable          = ['title', 'long_title', 'subtitle', 'summary', 'body', 'visible_as_page', 'header_id'];
    protected       $isPublishable     = true;
    protected array $atomReplaceFields = [
        'block_content' => 'atom-nucleus::html-elements.simple-wysiwyg-field'
    ];

    /**
     * De blokvelden verschijnen alleen op de vaste pagina's met een eigen
     * tekstsectie. Op andere pagina's doen ze niets, en ongebruikte velden in
     * het beheer nodigen uit tot verkeerd invullen.
     */
    public function getFillable(): array {
        $fillable = parent::getFillable();

        return match ($this->taxonomy_id ?? null) {
            // Diensten: "Voor wie we het doen" onder het stappenpad.
            // Doelgroepen: "Staat jouw situatie er niet bij?" onder de kaarten.
            TaxonomyMap::SERVICES->value,
            TaxonomyMap::AUDIENCES->value => [...$fillable, 'block_title', 'block_subtitle', 'block_content'],

            default                       => $fillable
        };
    }


    public function images(): MorphMany {
        return $this->morphMany(Media::class, 'model')->where('type', 'image')->orderBy('prio', 'asc');
    }

}
