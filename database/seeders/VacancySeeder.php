<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Domains\Page\Models\Page;
use App\Domains\Vacancy\Models\Vacancy;
use App\Support\TaxonomyMap;
use Illuminate\Database\Seeder;

/**
 * Vult Vacatures: vier vacatures en de teksten van de vacaturepagina.
 *
 * Titels, uren en standplaatsen komen uit het ontwerp in Claude Design; de
 * vacatureteksten zijn dummytekst. Of deze vacatures echt openstaan, weet
 * RoboGas: zet ze in het beheer offline als dat niet zo is.
 *
 * Opnieuw draaien is veilig: bestaande vacatures blijven staan, en alleen lege
 * paginavelden worden gevuld.
 *
 * Draaien met: php artisan db:seed --class=VacancySeeder
 */
final class VacancySeeder extends Seeder {

    /** titel, uren, standplaats */
    private const VACANCIES = [
        ['Monteur propaaninstallaties', '38 uur', 'Nijkerk'],
        ['Tankwagenchauffeur', '32 - 38 uur', 'Midden-Nederland'],
        ['Adviseur binnendienst', '24 - 32 uur', 'Nijkerk'],
        ['Leerling-monteur', 'BBL', 'Nijkerk'],
    ];

    private const BODY = '<p>Hier komt de vacaturetekst: wat je doet, wat je meebrengt en wat we je bieden. Deze tekst is een plaatshouder en wordt vervangen door de tekst van RoboGas.</p>'
        . '<h4>Wat je doet</h4><ul><li>Eerste taak</li><li>Tweede taak</li><li>Derde taak</li></ul>'
        . '<h4>Wat je meebrengt</h4><ul><li>Eerste eis</li><li>Tweede eis</li></ul>';

    private const PAGE = [
        'summary'        => 'Eén werkplaats in Nijkerk, eigen wagens en collega\'s die al jaren blijven.',
        'body'           => '<p>Bij RoboGas werk je in een familiebedrijf met korte lijnen. Geen callcenter, geen onderaannemers: de monteur die de tank plaatst, is dezelfde die er volgend jaar voor de keuring staat.</p>'
            . '<h4>Wat we bieden</h4><ul><li>Een vast team in Nijkerk, geen uitzendconstructies</li><li>Eigen servicewagen en gereedschap</li><li>Opleiding en certificering op onze kosten</li><li>Ruimte om door te groeien</li></ul>',
        'block_title'    => 'Sollicitatie sturen?',
        'block_subtitle' => 'We bellen dezelfde week terug',
    ];

    public function run(): void {
        foreach(self::VACANCIES as $priority => [$title, $hours, $location]) {
            $vacancy = Vacancy::query()->firstOrNew(['title' => $title]);

            if($vacancy->exists) {
                $this->command?->line('Bestaat al: ' . $title);
                continue;
            }

            $vacancy->forceFill([
                'title'     => $title,
                'hours'     => $hours,
                'location'  => $location,
                'body'      => self::BODY,
                'priority'  => $priority,
                'published' => 1,
            ])->save();

            $vacancy->createTaxonomy(parentId: TaxonomyMap::CAREERS->value);
            $this->command?->info('Aangemaakt: ' . $title);
        }

        $page = Page::query()->findOrFail(Page::query()->joined()->where('atom_taxonomies.id', TaxonomyMap::CAREERS->value)->value('atom_pages.id'));

        foreach(self::PAGE as $column => $value) {
            if(empty($page->getAttributes()[$column] ?? null)) {
                $page->{$column} = $value;
            }
        }

        $page->save();

        $this->command?->warn('Let op: de vacatures en teksten komen uit het ontwerp; RoboGas moet bevestigen welke echt openstaan.');
    }
}
