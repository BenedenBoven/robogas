<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Domains\Audience\Models\Audience;
use App\Domains\Page\Models\Page;
use App\Support\TaxonomyMap;
use Illuminate\Database\Seeder;

/**
 * Vult de zes doelgroepen en de teksten van het doelgroepenoverzicht.
 *
 * Teksten zijn plaatshouders uit het ontwerp in Claude Design, niet aangeleverd
 * door RoboGas. De teksten voor ballonvaart en heftrucks staan niet in het
 * ontwerp en zijn dummytekst. Koppelingen met diensten worden niet gezet: welke dienst
 * voor wie relevant is, bepaalt RoboGas.
 *
 * Opnieuw draaien is veilig: alleen lege velden worden gevuld, ingevulde
 * velden blijven staan.
 *
 * Draaien met: php artisan db:seed --class=AudienceSeeder
 */
final class AudienceSeeder extends Seeder {

    /** titel, icoon, samenvatting, voordelen, toepassingen */
    private const AUDIENCES = [
        ['Particulier', 'particulier', 'Een woning buiten het gasnet verwarm je met propaan net zo comfortabel als met aardgas.',
            "Verwarming, warm water en koken op één tank\nAutomatisch bijvullen, je hoeft nergens aan te denken\nTank ingeterpt of uit het zicht geplaatst",
            "CV-ketel\nGasfornuis\nHaard en terrasverwarming"],
        ['Agrarisch', 'agrarisch', 'Van stalverwarming tot onkruidbranders: agrarische bedrijven draaien op grote volumes en korte lijnen.',
            "Bulklevering op vaste momenten\nTanks tot 70 liter en meer op één erf\nEén aanspreekpunt voor keuring en onderhoud",
            "Stalverwarming\nOnkruidbranders\nDroog- en verwarmingsinstallaties"],
        ['Ballonvaart', 'ballonvaart', 'Een ballon vaart op propaan. Wij zorgen dat de flessen vol zijn voordat je de lucht in gaat.',
            "Flessen gevuld en gekeurd op het afgesproken moment\nOok vroeg in de ochtend of in het weekend\nEén aanspreekpunt voor vullen en keuren",
            "Branders\nReserveflessen\nGrondapparatuur"],
        ['Recreatie', 'recreatie', 'Chaletparken, campings en horeca leveren comfort aan gasten. Wij zorgen dat het gas klopt.',
            "Collectieve installaties voor hele parken\nFacturatie per chalet of centraal\nSeizoenspieken vooraf ingepland",
            "Chaletparken\nCampings en groepsaccommodaties\nKeukens en terrasverwarming"],
        ['Heftrucks', 'heftrucks', 'Een heftruck op propaan rijdt binnen en buiten, zonder laadpaal en zonder wachttijd.',
            "Wisselflessen altijd op voorraad\nOmruilen op vaste momenten of op afroep\nOpslag volgens de veiligheidsregels",
            "Heftrucks\nReachtrucks\nVeegmachines"],
        ['Bouw & industrie', 'bouw-industrie', 'Op de bouwplaats en in de fabriek is gas gereedschap. Het moet er zijn wanneer je het nodig hebt.',
            "Keetverwarming en bouwdrogers\nTijdelijke opstellingen, snel geplaatst\nOok heftrucks en industriële gassen",
            "Keetverwarming\nBouwdrogers en heaters\nHeftrucks"],
    ];

    private const PAGE = [
        'long_title'     => 'Voor wie we werken',
        'summary'        => 'Een woonboerderij, een chaletpark, een stal of een bouwkeet: het gas is hetzelfde, de aanpak niet.',
        'block_title'    => 'Staat jouw situatie er niet bij?',
        'block_subtitle' => 'Bel ons, we denken mee',
        'block_content'  => '<p>We leveren op meer plekken dan hier staan. Bel en leg je situatie voor.</p>',
    ];

    public function run(): void {
        foreach(self::AUDIENCES as $priority => [$title, $icon, $summary, $benefits, $uses]) {
            $audience = Audience::query()->firstOrNew(['title' => $title]);
            $isNew    = !$audience->exists;

            $values = [
                'title'      => $title,
                'long_title' => 'Propaan voor ' . mb_strtolower($title),
                'icon'       => $icon,
                'summary'    => $summary,
                'benefits'   => $benefits,
                'uses'       => $uses,
                'priority'   => $priority,
                'published'  => 1,
            ];

            // Ruwe waarden: de accessor van long_title valt terug op title en is dus nooit leeg.
            foreach($values as $column => $value) {
                if($isNew || empty($audience->getAttributes()[$column] ?? null)) {
                    $audience->{$column} = $value;
                }
            }

            $audience->save();

            if($isNew) {
                $audience->createTaxonomy(parentId: TaxonomyMap::AUDIENCES->value);
            }

            $this->command?->info(($isNew ? 'Aangemaakt: ' : 'Aangevuld: ') . $title);
        }

        $page = Page::query()->find(Page::query()->joined()->where('atom_taxonomies.id', TaxonomyMap::AUDIENCES->value)->value('atom_pages.id'));

        // Ruwe waarden: de accessor van long_title valt terug op title en is dus nooit leeg.
        foreach(self::PAGE as $column => $value) {
            if(empty($page->getAttributes()[$column] ?? null)) {
                $page->{$column} = $value;
            }
        }

        $page->save();

        $this->command?->warn('Let op: alle teksten zijn plaatshouders uit het ontwerp en moeten door RoboGas worden gecontroleerd.');
        $this->command?->warn('Ballonvaart en heftrucks hebben dummytekst, de body is overal leeg en er zijn geen diensten gekoppeld.');
    }
}
