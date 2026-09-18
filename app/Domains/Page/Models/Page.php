<?php declare(strict_types=1);

namespace App\Domains\Page\Models;

use App\Domains\Faq\Models\FaqTheme;
use App\Infrastructure\Traits\HasSteps;
use App\Support\TaxonomyMap;
use BenedenBoven\Atom\Application\Models\Page as AtomPage;
use BenedenBoven\Atom\Modules\Media\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    use HasSteps;

    /** Pagina's met een genummerde lijst stappen in het beheer. */
    private const WITH_STEPS = [TaxonomyMap::ORDER, TaxonomyMap::QUOTE, TaxonomyMap::MALFUNCTION];

    /** Welke FAQ-thema's op een pagina staan, kies je bij het thema. */
    protected $excludedRelationships = ['faqThemes', 'steps'];

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
            // Voor wie: "Staat jouw situatie er niet bij?" onder de kaarten.
            // Onze kennis: "Staat je vraag er niet bij?" onder de artikelen.
            // Vacatures: "Sollicitatie sturen?" onder de lijst.
            // Formulierpagina's: titel, intro en regel boven de knop van het formulierpaneel.
            TaxonomyMap::SERVICES->value,
            TaxonomyMap::AUDIENCES->value,
            TaxonomyMap::KNOWLEDGE->value,
            TaxonomyMap::CAREERS->value,
            TaxonomyMap::CONTACT->value,
            TaxonomyMap::ORDER->value,
            TaxonomyMap::QUOTE->value,
            TaxonomyMap::MALFUNCTION->value => [...$fillable, 'block_title', 'block_subtitle', 'block_content'],

            default                         => $fillable
        };
    }


    public function getExtraAtomTabs(): array {
        return $this->hasSteps() ? [$this->getStepsAtomTab()] : parent::getExtraAtomTabs();
    }

    public function getCustomSaveHandlers(string $when): array {
        return $when === 'after' && $this->hasSteps() ? $this->getStepsSaveHandler() : parent::getCustomSaveHandlers($when);
    }

    public function faqThemes(): BelongsToMany {
        return $this->belongsToMany(FaqTheme::class, 'rg_faq_themes_pages', 'page_id', 'faq_theme_id');
    }

    private function hasSteps(): bool {
        return in_array((int)($this->taxonomy_id ?? 0), array_map(fn(TaxonomyMap $map) => $map->value, self::WITH_STEPS), true);
    }

    public function images(): MorphMany {
        return $this->morphMany(Media::class, 'model')->where('type', 'image')->orderBy('prio', 'asc');
    }

}
