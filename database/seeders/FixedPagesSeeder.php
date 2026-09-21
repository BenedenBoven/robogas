<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Domains\Page\Models\Page;
use App\Support\TaxonomyMap;
use Illuminate\Database\Seeder;

/**
 * Maakt de vaste pagina's uit het ontwerp aan, zodat hun taxonomy-id's in de
 * TaxonomyMap kunnen. Opnieuw draaien is veilig: een pagina met dezelfde titel
 * op het hoogste niveau wordt overgeslagen.
 *
 * Draaien met: php artisan db:seed --class=FixedPagesSeeder
 * Zet daarna de getoonde id's in App\Support\TaxonomyMap.
 */
final class FixedPagesSeeder extends Seeder {

    /** TaxonomyMap-naam => paginatitel. De titel is ook het label in het menu. */
    private const PAGES = [
        'SERVICES'    => 'Diensten',
        'AUDIENCES'   => 'Gastanks',
        'CYLINDERS'   => 'Gasflessen',
        'SWITCH'      => 'Overstappen',
        'KNOWLEDGE'   => 'Onze kennis',
        'ABOUT'       => 'Over ons',
        'CAREERS'     => 'Vacatures',
        'BIOGAS'      => 'Biogas',
        'FAQ'         => 'Veelgestelde vragen',
        'CONTACT'     => 'Contact',
        'ORDER'       => 'Gas bestellen',
        'QUOTE'       => 'Offerte aanvragen',
        'MALFUNCTION' => 'Storing melden',
        'TERMS'       => 'Algemene voorwaarden',
        'PRIVACY'     => 'Privacyverklaring',
        'GERMAN'      => 'Deutsch',
    ];

    /**
     * Een eigen laatste url-deel, los van de titel. "Voor wie" is het label in
     * menu en kruimelpad; /gas-voor/particulier zegt wat je er vindt.
     */
    private const SLUGS = [
        'AUDIENCES' => 'gas-voor',
        'GERMAN'    => 'de',
    ];

    /**
     * Juridische teksten horen van de klant of diens jurist te komen, niet uit
     * een seeder. Deze notitie maakt zichtbaar dat er nog tekst bij moet.
     */
    private const LEGAL_PLACEHOLDER = '<p><strong>Deze tekst moet nog worden aangeleverd.</strong> '
        . 'Vervang deze alinea door de definitieve tekst voordat de website live gaat.</p>';

    /**
     * Pagina's uit het ontwerp waarvoor nog geen tekst is. De notitie staat in
     * de tekst zelf, zodat niemand een lege pagina live zet. Wordt alleen
     * gebruikt zolang het tekstveld leeg is.
     */
    private const PLACEHOLDERS = [
        'CYLINDERS' => '<h2>Gasflessen</h2><p><strong>Deze tekst moet nog worden aangeleverd.</strong> '
            . 'Hier komt het verhaal over gasflessen: welke maten er zijn, hoe je ze wisselt en waar je ze ophaalt of laat bezorgen.</p>',
        'SWITCH'    => '<h2>Overstappen naar RoboGas</h2><p><strong>Deze tekst moet nog worden aangeleverd.</strong> '
            . 'Hier komt het verhaal over overstappen: wat het je oplevert, hoe het overzetten van je tank werkt en wat wij regelen.</p>',
        'GERMAN'    => '<h2>RoboGas auf Deutsch</h2><p><strong>Dieser Text muss noch geliefert werden.</strong> '
            . 'Hier kommt die deutsche Seite: wer wir sind, was wir liefern und wie Sie uns erreichen.</p>'
            . '<p>RoboGas, Gildenstraat 20, 3861 RG Nijkerk, Niederlande. Telefon 033 - 245 25 45, info@robogas.nl.</p>',
    ];

    public function run(): void {
        foreach(self::PAGES as $case => $title) {
            // Eerst op taxonomy-id: staat de pagina al in de TaxonomyMap, dan is
            // dat de pagina, ook als de titel intussen anders is (Voor wie werd
            // Gastanks). Pas daarna op titel, voor een verse installatie.
            $map  = TaxonomyMap::tryFromName($case);
            $page = $map !== null
                ? Page::query()->joined()->where('atom_taxonomies.id', $map->value)->first()
                : null;

            $page ??= Page::query()->joined()->where('atom_pages.title', $title)->where('atom_taxonomies.parent_id', 0)->first();

            if($page === null) {
                $page = new Page();
                $page->forceFill([
                    'title'           => $title,
                    'body'            => in_array($case, ['TERMS', 'PRIVACY'], true) ? self::LEGAL_PLACEHOLDER : '',
                    'long_title'      => $case === 'CAREERS' ? 'Werken bij RoboGas' : null,
                    'visible_as_page' => 1,
                    'published'       => 1,
                ])->save();
                $page->createTaxonomy(parentId: 0);

                if(isset(self::SLUGS[$case])) {
                    $page->load('taxonomy');
                    $page->updateTaxonomy(parentId: 0, customSlug: self::SLUGS[$case]);
                }
            }

            // Een pagina zonder tekst krijgt de plaatshouder, ook als de pagina er al was.
            if(isset(self::PLACEHOLDERS[$case]) && trim(strip_tags((string)($page->getAttributes()['body'] ?? ''))) === '') {
                $page->body = self::PLACEHOLDERS[$case];
                $page->save();
                $this->command?->line('Plaatshoudertekst gezet: ' . $title);
            }

            // De titel in deze seeder is leidend: hij is ook het label in het menu.
            if($page->title !== $title) {
                $this->command?->line('Hernoemd: ' . $page->title . ' wordt ' . $title);
                $page->title = $title;
                $page->save();
            }

            $taxonomy = $page->taxonomy()->first();
            $this->command?->info(sprintf('case %-11s = %d;  // %s', $case, $taxonomy->id, $taxonomy->url));
        }
    }
}
