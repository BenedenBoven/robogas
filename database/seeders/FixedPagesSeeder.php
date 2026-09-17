<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Domains\Page\Models\Page;
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

    /** TaxonomyMap-naam => paginatitel */
    private const PAGES = [
        'SERVICES'    => 'Diensten',
        'AUDIENCES'   => 'Doelgroepen',
        'KNOWLEDGE'   => 'Onze kennis',
        'ABOUT'       => 'Over ons',
        'CAREERS'     => 'Werken bij RoboGas',
        'BIOGAS'      => 'Biogas',
        'FAQ'         => 'Veelgestelde vragen',
        'CONTACT'     => 'Contact',
        'ORDER'       => 'Gas bestellen',
        'QUOTE'       => 'Offerte aanvragen',
        'MALFUNCTION' => 'Storing melden',
        'TERMS'       => 'Algemene voorwaarden',
        'PRIVACY'     => 'Privacyverklaring',
    ];

    /**
     * Juridische teksten horen van de klant of diens jurist te komen, niet uit
     * een seeder. Deze notitie maakt zichtbaar dat er nog tekst bij moet.
     */
    private const LEGAL_PLACEHOLDER = '<p><strong>Deze tekst moet nog worden aangeleverd.</strong> '
        . 'Vervang deze alinea door de definitieve tekst voordat de website live gaat.</p>';

    public function run(): void {
        foreach(self::PAGES as $case => $title) {
            $page = Page::query()->joined()->where('atom_pages.title', $title)->where('atom_taxonomies.parent_id', 0)->first();

            if($page === null) {
                $page = new Page();
                $page->forceFill([
                    'title'           => $title,
                    'body'            => in_array($case, ['TERMS', 'PRIVACY'], true) ? self::LEGAL_PLACEHOLDER : '',
                    'visible_as_page' => 1,
                    'published'       => 1,
                ])->save();
                $page->createTaxonomy(parentId: 0);
            }

            $taxonomy = $page->taxonomy()->first();
            $this->command?->info(sprintf('case %-11s = %d;  // %s', $case, $taxonomy->id, $taxonomy->url));
        }
    }
}
