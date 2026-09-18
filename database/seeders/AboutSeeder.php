<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Atom\Steps\StepList;
use App\Domains\Page\Models\Page;
use App\Domains\Step\Models\Step;
use App\Support\TaxonomyMap;
use Illuminate\Database\Seeder;

/**
 * Vult Over ons: de teksten, de kerncijfers en de mijlpalen.
 *
 * Alles komt uit het ontwerp in Claude Design en is niet gecontroleerd. De
 * jaartallen, "66 jaar", "4 eigen servicewagens" en Robo Gascentrale B.V. moet
 * RoboGas bevestigen voordat de website live gaat.
 *
 * Opnieuw draaien is veilig: alleen lege paginavelden worden gevuld, en een
 * lijst die al regels heeft blijft staan.
 *
 * Draaien met: php artisan db:seed --class=AboutSeeder
 */
final class AboutSeeder extends Seeder {

    private const PAGE = [
        'long_title'     => 'Wij zijn RoboGas',
        'subtitle'       => 'Sinds 1960, zelfstandig',
        'summary'        => 'Een zelfstandige propaangasleverancier uit Nijkerk. Geen tussenpersoon, geen callcenter: eigen monteurs, eigen wagens, eigen mensen aan de telefoon.',
        'body'           => '<h2>Zelfstandig, en dat blijven we</h2>'
            . '<p>RoboGas is onderdeel van Robo Gascentrale B.V., een familiebedrijf dat al 66 jaar propaan levert in Midden-Nederland. We zijn niet aangesloten bij een van de grote energieconcerns. Dat betekent dat we zelf bepalen wat we beloven en dat je dezelfde mensen aan de lijn krijgt als vorig jaar.</p>'
            . '<p>Waar anderen alleen gas verkopen, doen wij de hele keten: <strong>advies, planvorming, installatie, levering en service</strong>. Dat scheelt je een installateur zoeken, een keuring regelen en drie partijen naar elkaar laten wijzen als er iets niet werkt.</p>'
            . '<h4>Waar we voor staan</h4>'
            . '<ul><li>Eén aanspreekpunt, van eerste vraag tot bijvullen</li><li>Eigen monteurs, geen onderaannemers</li><li>Heldere offerte vooraf, geen verrassingen achteraf</li><li>We weten wanneer je moet bijvullen, voordat je het zelf merkt</li></ul>',
        'block_title'    => 'Van gasflessen naar de hele keten',
        'block_subtitle' => 'Onze geschiedenis',
    ];

    /** getal, omschrijving */
    private const FACTS = [
        ['66', 'jaar ervaring'],
        ['4', 'eigen servicewagens'],
        ['1', 'aanspreekpunt'],
    ];

    /** jaar, titel, toelichting */
    private const MILESTONES = [
        ['1960', 'Robo Gascentrale opgericht', 'Begonnen met gasflessen voor de omgeving van Nijkerk.'],
        ['1985', 'Eerste eigen tankwagen', 'Bulklevering in eigen beheer, zonder tussenpartij.'],
        ['2005', 'Installatie en keuring erbij', 'Eigen monteurs, zodat de hele keten bij ons ligt.'],
        ['2026', 'Biopropaan op aanvraag', 'Dezelfde installatie, een lagere CO₂-uitstoot.'],
    ];

    public function run(): void {
        $page = Page::query()->findOrFail(Page::query()->joined()->where('atom_taxonomies.id', TaxonomyMap::ABOUT->value)->value('atom_pages.id'));

        foreach(self::PAGE as $column => $value) {
            $current = $page->getAttributes()[$column] ?? null;

            // Bij opslaan in het beheer wordt een lege lange titel de titel; dan telt hij als leeg.
            if(empty($current) || ($column === 'long_title' && $current === $page->title)) {
                $page->{$column} = $value;
            }
        }
        $page->save();

        $this->fill($page, StepList::FACTS, array_map(static fn(array $fact) => [$fact[0], $fact[1], null], self::FACTS));
        $this->fill($page, StepList::MILESTONES, self::MILESTONES);

        $this->command?->warn('Let op: de teksten, cijfers en jaartallen komen uit het ontwerp; RoboGas moet ze bevestigen.');
    }

    /** @param list<array{0: string, 1: string, 2: string|null}> $rows */
    private function fill(Page $page, StepList $list, array $rows): void {
        if($page->stepList($list)->exists()) {
            $this->command?->line($list->tabTitle() . ': staan er al, overgeslagen.');

            return;
        }

        foreach($rows as $prio => [$label, $title, $summary]) {
            Step::query()->create([
                'model_type' => $page->getMorphClass(),
                'model_id'   => $page->getKey(),
                'list'       => $list->value,
                'label'      => $label,
                'title'      => $title,
                'summary'    => $summary,
                'prio'       => $prio,
            ]);
        }

        $this->command?->info($list->tabTitle() . ': ' . count($rows) . ' aangemaakt.');
    }
}
