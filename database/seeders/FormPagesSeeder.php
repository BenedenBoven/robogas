<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Domains\Faq\Models\Faq;
use App\Domains\Faq\Models\FaqTheme;
use App\Domains\Page\Models\Page;
use App\Domains\Step\Models\Step;
use App\Support\TaxonomyMap;
use Illuminate\Database\Seeder;

/**
 * Vult de pagina's met een formulier (Contact, Gas bestellen, Offerte aanvragen,
 * Storing melden): header, formulierpaneel, zijbalk, stappen en veelgestelde
 * vragen.
 *
 * Alle teksten zijn plaatshouders uit het ontwerp in Claude Design, niet
 * aangeleverd door RoboGas. Let vooral op de noodstappen bij Storing melden:
 * die moeten door RoboGas worden gecontroleerd voordat de site live gaat.
 *
 * Opnieuw draaien is veilig: alleen lege velden worden gevuld, en stappen,
 * thema's en vragen alleen als ze er nog niet zijn.
 *
 * Draaien met: php artisan db:seed --class=FormPagesSeeder
 */
final class FormPagesSeeder extends Seeder {

    private const PAGES = [
        'CONTACT'     => [
            'subtitle'      => 'Werkdagen 8.00 - 17.00 uur',
            'summary'       => 'Eén belletje en het loopt. Je krijgt iemand uit Nijkerk aan de lijn die je installatie kent.',
            'block_title'   => 'Contactformulier',
            'block_content' => '<p>Laat je gegevens achter, dan bellen of mailen we je terug. Meestal dezelfde werkdag.</p>',
        ],
        'ORDER'       => [
            'subtitle'       => 'Levering plannen',
            'summary'        => 'Vul je gegevens in, dan plannen we de levering. Ben je nieuwe klant? Dan rekenen we eerst je verbruik door.',
            'block_title'    => 'Bestelformulier',
            'block_content'  => '<p>Je bestelling komt direct bij onze planning binnen. We bevestigen de leverdatum per e-mail.</p>',
            'block_subtitle' => 'We tonen geen prijzen op de website: de propaanprijs beweegt mee met de markt en met je jaarverbruik. Je krijgt altijd een prijs op maat.',
            'body'           => '<h5>Liever telefonisch bestellen?</h5><p>Bel 033 - 245 25 45 op werkdagen tussen 8.00 en 17.00 uur. Je krijgt meteen een leverdatum.</p>',
        ],
        'QUOTE'       => [
            'subtitle'       => 'Prijs op maat',
            'summary'        => 'Vertel ons waar je woont of werkt en wat je stookt. Wij rekenen je verbruik door en komen met een prijs op maat.',
            'block_title'    => 'Offerteaanvraag',
            'block_content'  => '<p>Je krijgt antwoord van een adviseur uit Nijkerk, geen standaard e-mail.</p>',
            'block_subtitle' => 'Prijzen staan niet op de website. De propaanprijs beweegt mee met de markt en met je jaarverbruik.',
            'body'           => '<h5>Geen prijslijst?</h5><p>Klopt. De propaanprijs beweegt mee met de markt en met je jaarverbruik. Je krijgt daarom altijd een prijs op maat.</p>',
        ],
        'MALFUNCTION' => [
            'subtitle'      => 'Voor alle andere storingen gebruik je het formulier',
            'block_title'   => 'Storingsmelding',
            'block_content' => '<p>Geen gaslucht, maar wel een storing? Beschrijf hieronder wat er aan de hand is. Meldingen op werkdagen voor 15.00 uur pakken we dezelfde dag op.</p>',
            'body'          => '<h5>Bereikbaarheid</h5><p>Werkdagen 8.00 - 17.00 uur. Buiten kantoortijd is de storingsdienst bereikbaar op hetzelfde nummer.</p>',
        ],
    ];

    /** titel, toelichting */
    private const STEPS = [
        'ORDER'       => [
            ['We plannen de rit', 'Je bestelling gaat direct naar de planning in Nijkerk.'],
            ['Je krijgt een leverdatum', 'Per e-mail, met een tijdvak waarin we komen.'],
            ['We vullen bij', 'Eigen chauffeur, eigen wagen. Je hoeft er niet bij te zijn.'],
        ],
        'QUOTE'       => [
            ['We bellen je', 'Voor een paar details over je situatie en wat je nu stookt.'],
            ['We rekenen door', 'Tankinhoud, plaatsing, keuring en levering, in één prijs.'],
            ['Je krijgt de offerte', 'Met een geldigheidsdatum erin.'],
        ],
        'MALFUNCTION' => [
            ['Sluit de hoofdkraan op de tank of fles.', null],
            ['Ventileer: zet ramen en deuren open.', null],
            ['Gebruik geen schakelaars, telefoons of open vuur binnen.', null],
            ['Ga naar buiten en bel ons. Bij acuut gevaar eerst 112.', null],
        ],
    ];

    /** thema => [pagina's, [vraag, antwoord]] */
    private const FAQ = [
        'Bestellen'               => [['ORDER'], [
            ['Waarom staan de prijzen niet op de website?', 'De propaanprijs beweegt mee met de markt en met je jaarverbruik. We geven daarom altijd een prijs op maat.'],
            ['Hoe weet ik wanneer ik moet bijbestellen?', 'Bij automatisch bijvullen houden wij je verbruik bij en komen we langs voordat de tank leeg is. Bestel je zelf? Doe dat bij ongeveer 30% tankinhoud, dan heb je ruim de tijd.'],
            ['Hoe snel wordt er geleverd?', 'Een reguliere levering plannen we zo snel mogelijk in. In het stookseizoen is het drukker; bestel daarom niet op het laatste moment.'],
        ]],
        'Tank en installatie'     => [['QUOTE'], [
            ['Mag de tank ondergronds?', 'Ja. Een ingeterpte of ondergrondse tank is uit het zicht en scheelt ruimte. We beoordelen vooraf of de locatie en de grondwaterstand het toelaten.'],
            ['Hoeveel ruimte moet er om de tank vrij blijven?', 'Dat hangt af van de tankinhoud en de omgeving. We toetsen de veiligheidsafstanden tijdens de planvorming, voordat er iets geplaatst wordt.'],
            ['Wie keurt de installatie?', 'Wij regelen de keuring en het periodiek onderhoud. Je krijgt de keuringsdocumenten in je dossier.'],
        ]],
        'Veiligheid en storingen' => [['MALFUNCTION'], [
            ['Wat doe ik bij een gaslucht?', 'Sluit de hoofdkraan op de tank, ventileer, gebruik geen schakelaars of open vuur en ga naar buiten. Bel daarna onze storingsdienst.'],
            ['Is propaan veilig in huis?', 'Ja, mits de installatie gekeurd is en onderhouden wordt. Propaan is zwaarder dan lucht, daarom gelden er eisen aan ventilatie en opstelling.'],
        ]],
    ];

    public function run(): void {
        $pages = [];

        foreach(self::PAGES as $case => $values) {
            $page = $this->page($case);
            $pages[$case] = $page;

            // Ruwe waarden: de accessor van long_title valt terug op title en is dus nooit leeg.
            foreach($values as $column => $value) {
                if(empty($page->getAttributes()[$column] ?? null)) {
                    $page->{$column} = $value;
                }
            }

            $page->save();
            $this->command?->info('Pagina gevuld: ' . $page->title);
        }

        foreach(self::STEPS as $case => $steps) {
            $page = $pages[$case];

            if(Step::query()->where('model_type', $page->getMorphClass())->where('model_id', $page->id)->exists()) {
                continue;
            }

            foreach($steps as $prio => [$title, $summary]) {
                Step::query()->create([
                    'model_type' => $page->getMorphClass(),
                    'model_id'   => $page->id,
                    'title'      => $title,
                    'summary'    => $summary,
                    'prio'       => $prio,
                ]);
            }
        }

        $themePriority = 0;

        foreach(self::FAQ as $themeTitle => [$themePages, $questions]) {
            $theme = FaqTheme::query()->firstOrNew(['title' => $themeTitle]);

            if(!$theme->exists) {
                $theme->forceFill(['title' => $themeTitle, 'priority' => $themePriority, 'published' => 1])->save();

                foreach($questions as $priority => [$question, $answer]) {
                    (new Faq())->forceFill([
                        'faq_theme_id' => $theme->id,
                        'title'        => $question,
                        'body'         => '<p>' . e($answer) . '</p>',
                        'priority'     => $priority,
                        'published'    => 1,
                    ])->save();
                }
            }

            $theme->pages()->syncWithoutDetaching(array_map(fn(string $case) => $pages[$case]->id, $themePages));
            $themePriority++;
        }

        $this->command?->warn('Let op: alle teksten zijn plaatshouders uit het ontwerp. De noodstappen bij Storing melden moeten door RoboGas worden gecontroleerd.');
    }

    private function page(string $case): Page {
        $id = Page::query()->joined()->where('atom_taxonomies.id', constant(TaxonomyMap::class . '::' . $case)->value)->value('atom_pages.id');

        return Page::query()->findOrFail($id);
    }
}
