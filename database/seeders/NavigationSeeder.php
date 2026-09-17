<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Support\TaxonomyMap;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Vult het hoofdmenu (Atom-menu "default") met de items uit het ontwerp.
 *
 * Het label van een item is de titel van de pagina. Onder Diensten en
 * Doelgroepen verschijnt het mega-menu vanzelf; zie MainNavigationComposer.
 * Opnieuw draaien is veilig: bestaande items krijgen alleen hun volgorde terug.
 *
 * Draaien met: php artisan db:seed --class=NavigationSeeder
 */
final class NavigationSeeder extends Seeder {

    private const SLUG = 'default';

    private const ITEMS = [
        TaxonomyMap::SERVICES,
        TaxonomyMap::AUDIENCES,
        TaxonomyMap::KNOWLEDGE,
        TaxonomyMap::ABOUT,
        TaxonomyMap::CONTACT,
        TaxonomyMap::CAREERS,
    ];

    public function run(): void {
        $navigationId = DB::table('atom_navigation')->where('slug', self::SLUG)->value('id');

        if($navigationId === null) {
            $this->command?->error('Menu ' . self::SLUG . ' bestaat niet.');

            return;
        }

        foreach(self::ITEMS as $prio => $map) {
            DB::table('atom_navigation_items')->updateOrInsert(
                ['navigation_id' => $navigationId, 'taxonomy_id' => $map->value, 'parent_id' => null],
                ['prio' => $prio, 'updated_at' => now(), 'created_at' => now()]
            );

            $this->command?->info('Menu-item: ' . $map->name);
        }
    }
}
