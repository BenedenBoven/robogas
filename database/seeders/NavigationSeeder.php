<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Support\TaxonomyMap;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Vult het hoofdmenu (Atom-menu "default") en het menu met de uitgelichte
 * links in de uitklap van Gastanks, uit het ontwerp in Adobe XD.
 *
 * Het label van een item is de titel van de pagina. Onder Gastanks verschijnt
 * de uitklap vanzelf; zie MainNavigationComposer. Opnieuw draaien is veilig:
 * bestaande items krijgen alleen hun volgorde terug.
 *
 * Draaien met: php artisan db:seed --class=NavigationSeeder
 */
final class NavigationSeeder extends Seeder {

    private const MENUS = [
        // slug => [titel in het beheer, de items op volgorde]
        'default'   => ['Default', [
            TaxonomyMap::AUDIENCES,
            TaxonomyMap::CYLINDERS,
            TaxonomyMap::KNOWLEDGE,
            TaxonomyMap::ABOUT,
            TaxonomyMap::SWITCH,
            TaxonomyMap::CAREERS,
            TaxonomyMap::CONTACT,
        ]],
        // De lijst rechts in de uitklap van Gastanks. In het ontwerp staan hier
        // teksten als "Mijn voordeel berekenen"; die pagina's bestaan nog niet,
        // dus staan hier de pagina's die er het dichtst bij liggen. De redactie
        // past het menu in het beheer aan.
        'uitgelicht' => ['Uitgelicht in de uitklap', [
            TaxonomyMap::QUOTE,
            TaxonomyMap::SWITCH,
            TaxonomyMap::ORDER,
            TaxonomyMap::KNOWLEDGE,
            TaxonomyMap::FAQ,
        ]],
    ];

    public function run(): void {
        foreach(self::MENUS as $slug => [$title, $items]) {
            $navigationId = DB::table('atom_navigation')->where('slug', $slug)->value('id');

            if($navigationId === null) {
                $navigationId = DB::table('atom_navigation')->insertGetId([
                    'slug' => $slug, 'title' => $title, 'created_at' => now(), 'updated_at' => now(),
                ]);
                $this->command?->info('Menu aangemaakt: ' . $title);
            }

            foreach($items as $prio => $map) {
                DB::table('atom_navigation_items')->updateOrInsert(
                    ['navigation_id' => $navigationId, 'taxonomy_id' => $map->value, 'parent_id' => null],
                    ['prio' => $prio, 'updated_at' => now(), 'created_at' => now()]
                );
            }

            // Items die de redactie zelf toevoegde blijven staan; alleen wat uit
            // een eerdere versie van deze seeder komt en er niet meer in hoort,
            // verdwijnt. Daarom niets verwijderen: dat doet de redactie.
            $this->command?->info($title . ': ' . count($items) . ' items bijgewerkt.');
        }
    }
}
