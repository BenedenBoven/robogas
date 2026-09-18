<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Domains\Page\Models\Page;
use App\Domains\Service\Models\Service;
use App\Support\TaxonomyMap;
use Illuminate\Database\Seeder;

/**
 * Vult de vijf stappen van de A-tot-Z aanpak en de teksten van het
 * dienstenoverzicht.
 *
 * Alle teksten zijn plaatshouders uit het ontwerp in Claude Design, niet
 * aangeleverd door RoboGas. Opnieuw draaien is veilig: bestaande diensten en
 * al ingevulde paginavelden worden niet overschreven.
 *
 * Draaien met: php artisan db:seed --class=ServiceSeeder
 */
final class ServiceSeeder extends Seeder {

    private const WE_NEED = "Je adres en het type gebouw of bedrijf\nEen indicatie van je jaarverbruik, of wat je nu stookt\nRuimte voor de wagen om bij de opstelplaats te komen";

    /** Dummytekst, zodat de leeskolom op de detailpagina te beoordelen is. */
    private const BODY = '<p>Hier komt de uitleg van deze stap: wat er gebeurt, wie je aan de lijn krijgt en hoe lang het duurt. Deze tekst is een plaatshouder en wordt vervangen door de tekst van RoboGas.</p>'
        . '<p>Twee of drie korte alinea\'s werken het best. Begin met wat de klant eraan heeft, en eindig met wat er daarna gebeurt.</p>'
        . '<h4>Goed om te weten</h4><p>Klopt er iets niet of verandert je situatie? Bel ons. We schuiven liever op dan dat we iets plaatsen wat niet past.</p>';

    private const SERVICES = [
        ['Advies', 'advies', 'We rekenen je verbruik door en bepalen welke tank of fles bij je past.', "Verbruik doorrekenen\nLocatie en bereikbaarheid beoordelen\nHeldere offerte, geen verrassingen"],
        ['Planvorming', 'planvorming', 'Tekening, vergunning en veiligheidsafstanden regelen we vooraf.', "Situatietekening\nVeiligheidsafstanden toetsen\nAfstemming met gemeente of installateur"],
        ['Installatie', 'installatie', 'Onze eigen monteurs plaatsen de tank en sluiten de installatie aan.', "Plaatsing bovengronds of ingeterpt\nLeidingwerk en drukregelaars\nKeuring en oplevering"],
        ['Levering', 'levering', 'We houden je verbruik bij en vullen bij voordat je het merkt.', "Automatisch bijvullen\nTelemetrie op de tank\nBestellen kan altijd zelf"],
        ['Service', 'service', 'Keuring, onderhoud en storingen: één nummer, eigen mensen.', "Periodieke keuring\nOnderhoud aan regelaars en leidingen\nStoringsdienst"],
    ];

    private const PAGE = [
        'subtitle'       => 'Onze A-tot-Z aanpak',
        'long_title'     => 'Van A tot Z geregeld',
        'summary'        => 'Advies, planvorming, installatie, levering en service. Vijf stappen, één partij, één aanspreekpunt.',
        'block_title'    => 'Voor wie we het doen',
        'block_subtitle' => 'Gas voor elke situatie',
        'block_content'  => '<p>Je hoeft niet bij stap 1 te beginnen. Heb je al een tank staan? Dan pakken we het op vanaf levering en service.</p>',
    ];

    public function run(): void {
        foreach(self::SERVICES as $priority => [$title, $icon, $summary, $weDo]) {
            $service = Service::query()->firstOrNew(['title' => $title]);

            if($service->exists) {
                // Alleen de dummytekst aanvullen als die nog leeg is.
                if(empty($service->getAttributes()['body'] ?? null)) {
                    $service->forceFill(['body' => self::BODY])->save();
                    $this->command?->line('Tekst aangevuld: ' . $title);
                }
                continue;
            }

            $service->forceFill([
                'title'     => $title,
                'icon'      => $icon,
                'summary'   => $summary,
                'we_do'     => $weDo,
                'we_need'   => self::WE_NEED,
                'body'      => self::BODY,
                'priority'  => $priority,
                'published' => 1,
            ])->save();

            $service->createTaxonomy(parentId: TaxonomyMap::SERVICES->value);
            $this->command?->info('Aangemaakt: ' . $title);
        }

        $page = Page::query()->find(Page::query()->joined()->where('atom_taxonomies.id', TaxonomyMap::SERVICES->value)->value('atom_pages.id'));

        // Ruwe waarden: de accessor van long_title valt terug op title en is dus nooit leeg.
        foreach(self::PAGE as $column => $value) {
            if(empty($page->getAttributes()[$column] ?? null)) {
                $page->{$column} = $value;
            }
        }

        $page->save();

        $this->command?->warn('Let op: alle teksten zijn plaatshouders uit het ontwerp en moeten door RoboGas worden gecontroleerd.');
        $this->command?->warn('De tekst van de diensten is dummytekst; die moet van RoboGas komen.');
    }
}
