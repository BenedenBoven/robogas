<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Domains\Page\Models\Page;
use App\Support\TaxonomyMap;
use Illuminate\Database\Seeder;

/**
 * Vult Biogas: de teksten, de vergelijkingstabel in de tekst en het gele blok.
 *
 * Alles komt uit het ontwerp in Claude Design en is niet gecontroleerd. Wat
 * RoboGas nu echt levert en hoe beschikbaar biopropaan is, moet RoboGas
 * bevestigen voordat de website live gaat.
 *
 * Opnieuw draaien is veilig: alleen lege paginavelden worden gevuld.
 *
 * Draaien met: php artisan db:seed --class=BiogasSeeder
 */
final class BiogasSeeder extends Seeder {

    private const PAGE = [
        'long_title'     => 'Biopropaan en biogas',
        'subtitle'       => 'Stap voor stap verduurzamen',
        'summary'        => 'Dezelfde tank, dezelfde installatie, een lagere CO₂-uitstoot. We bouwen dit aanbod stap voor stap uit.',
        'body'           => '<h2>Wat is biopropaan?</h2>'
            . '<p>Biopropaan is chemisch gelijk aan gewoon propaan, maar gemaakt uit hernieuwbare grondstoffen zoals plantaardige rest- en afvalstromen. Je installatie merkt het verschil niet: dezelfde tank, dezelfde regelaars, dezelfde branders.</p>'
            . '<h4>Wat het je oplevert</h4>'
            . '<ul><li>Een aanzienlijk lagere CO₂-uitstoot dan fossiel propaan</li><li>Geen aanpassing aan je installatie nodig</li><li>Dezelfde leverzekerheid en dezelfde servicedienst</li></ul>'
            . '<h4>Propaan naast biopropaan</h4>'
            . '<table><tbody>'
            . '<tr><td></td><td>Propaan</td><td>Biopropaan</td></tr>'
            . '<tr><td>Tank en installatie</td><td>Ongewijzigd</td><td>Ongewijzigd</td></tr>'
            . '<tr><td>Regelaars en branders</td><td>Ongewijzigd</td><td>Ongewijzigd</td></tr>'
            . '<tr><td>CO₂-uitstoot</td><td>Fossiel</td><td>Aanzienlijk lager</td></tr>'
            . '<tr><td>Leverzekerheid</td><td>Altijd op voorraad</td><td>Op aanvraag, groeiend</td></tr>'
            . '<tr><td>Servicedienst</td><td>Eigen monteurs</td><td>Eigen monteurs</td></tr>'
            . '</tbody></table>'
            . '<h4>Waar we nu staan</h4>'
            . '<p>We leveren biopropaan op aanvraag en breiden dat uit naarmate de beschikbaarheid groeit. Wil je weten of het voor jouw situatie al kan? Vraag het ons; we rekenen het door en zijn eerlijk over wat wel en niet kan.</p>',
        'block_title'    => 'Kan het al in jouw situatie?',
        'block_subtitle' => 'We rekenen het eerlijk door',
        'block_content'  => '<p>Vertel ons wat je stookt en hoeveel, dan zeggen we wat er nu kan en wat het kost.</p>',
    ];

    public function run(): void {
        $page = Page::query()->findOrFail(Page::query()->joined()->where('atom_taxonomies.id', TaxonomyMap::BIOGAS->value)->value('atom_pages.id'));

        foreach(self::PAGE as $column => $value) {
            $current = $page->getAttributes()[$column] ?? null;

            // Bij opslaan in het beheer wordt een lege lange titel de titel; dan telt hij als leeg.
            if(empty($current) || ($column === 'long_title' && $current === $page->title)) {
                $page->{$column} = $value;
            }
        }
        $page->save();

        $this->command?->warn('Let op: de teksten en de vergelijking komen uit het ontwerp; RoboGas moet ze bevestigen.');
    }
}
