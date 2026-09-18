<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Support\TaxonomyMap;
use BenedenBoven\Atom\Application\Models\Taxonomy;
use Illuminate\Database\Seeder;

/**
 * Vult de 404-pagina met een korte tekst en links naar de pagina's waar de
 * meeste bezoekers naar zoeken. Na de installatie stond er lorem ipsum.
 *
 * De tekst is een voorstel van BenedenBoven in de toon van het ontwerp; RoboGas
 * kan hem in het beheer aanpassen. Opnieuw draaien overschrijft alleen een lege
 * tekst of de lorem ipsum van de installatie.
 *
 * Draaien met: php artisan db:seed --class=NotFoundSeeder
 */
final class NotFoundSeeder extends Seeder {

    /** Pagina's in de lijst, met de tekst ervoor. De url komt uit de taxonomy. */
    private const LINKS = [
        [TaxonomyMap::ORDER, 'Gas nodig?'],
        [TaxonomyMap::MALFUNCTION, 'Storing?'],
        [TaxonomyMap::SERVICES, 'Wat we doen:'],
        [TaxonomyMap::KNOWLEDGE, 'Een vraag over propaan?'],
        [TaxonomyMap::CONTACT, 'Of gewoon even bellen:'],
    ];

    public function run(): void {
        $taxonomy = Taxonomy::query()->with('model')->findOrFail(TaxonomyMap::NOT_FOUND->value);
        $page     = $taxonomy->getModel();

        $body = (string)($page->getAttributes()['body'] ?? '');

        if(trim(strip_tags($body)) !== '' && !str_contains($body, 'dolor')) {
            $this->command?->line('De 404 heeft al een eigen tekst; overgeslagen.');

            return;
        }

        $items = '';
        foreach(self::LINKS as [$map, $lead]) {
            $target = Taxonomy::query()->with('model')->find($map->value);

            if($target !== null) {
                $items .= '<li>' . e($lead) . ' <a href="' . e($target->url) . '">' . e($target->getModel()->title) . '</a></li>';
            }
        }

        $page->body = '<p>Misschien is de pagina verhuisd, of zat er een tikfout in de link. Geen probleem: hier vind je de rest.</p>'
            . '<ul>' . $items . '</ul>';

        if(empty($page->getAttributes()['summary'] ?? null)) {
            $page->summary = 'Deze pagina hebben we niet kunnen vinden.';
        }

        $page->save();

        $this->command?->info('De 404 heeft een tekst gekregen.');
    }
}
