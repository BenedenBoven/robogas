<?php declare(strict_types=1);

use App\Support\TaxonomyMap;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private const SLUG = 'diensten';

    /**
     * De vijf stappen van de A-tot-Z aanpak: advies, planvorming, installatie,
     * levering en service.
     *
     * Het stapnummer wordt niet ingevoerd maar volgt uit de volgorde in het
     * beheer, zodat "Stap 03 van 5" nooit uit de pas loopt als er een stap bij
     * komt. we_do en we_need zijn opsommingen met één punt per regel.
     */
    public function up(): void {
        Schema::create('rg_services', function(Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('icon', ['advies', 'planvorming', 'installatie', 'levering', 'service'])->default('advies');
            $table->text('summary')->nullable();
            $table->longText('body')->nullable();
            $table->text('we_do')->nullable()->comment('Eén punt per regel');
            $table->text('we_need')->nullable()->comment('Eén punt per regel');
            $table->unsignedBigInteger('header_id')->nullable();
            $table->integer('priority')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        $moduleId = DB::table('atom_modules')->insertGetId([
            'slug'                    => self::SLUG,
            'creates_taxonomy'        => 1,
            'title_singular'          => 'Dienst',
            'title_plural'            => 'Diensten',
            'model'                   => 'App\Domains\Service\Models\Service',
            'allow_children'          => 0,
            'default_parent_id'       => (string)TaxonomyMap::SERVICES->value,
            'controller'              => 'GenericController',
            'blade_folder'            => 'generic',
            'icon'                    => 'fa-regular fa-list-ol',
            'benedenboven_group_only' => 0,
            'in_menu'                 => 1,
            'organizable'             => 1,
            'publishable'             => 1,
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);

        $this->addToAdminMenu($moduleId);
    }

    /**
     * Een module verschijnt pas in het beheermenu als er ook een rij in
     * atom_admin_navigation staat; de vlag in_menu alleen is niet genoeg.
     * Diensten komen direct na Pagina's.
     */
    private function addToAdminMenu(int $moduleId): void {
        $afterId = DB::table('atom_modules')->where('slug', 'paginas')->value('id');
        $after   = $afterId ? DB::table('atom_admin_navigation')->where('module_id', $afterId)->first() : null;
        $prio    = $after ? $after->prio + 1 : (int)DB::table('atom_admin_navigation')->max('prio') + 1;

        DB::table('atom_admin_navigation')->where('prio', '>=', $prio)->increment('prio');

        DB::table('atom_admin_navigation')->insert([
            'module_id'  => $moduleId,
            'title'      => '',
            'prio'       => $prio,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void {
        $moduleId = DB::table('atom_modules')->where('slug', self::SLUG)->value('id');

        if($moduleId !== null) {
            $prio = DB::table('atom_admin_navigation')->where('module_id', $moduleId)->value('prio');

            DB::table('atom_admin_navigation')->where('module_id', $moduleId)->delete();

            if($prio !== null) {
                DB::table('atom_admin_navigation')->where('prio', '>', $prio)->decrement('prio');
            }
        }

        DB::table('atom_modules')->where('slug', self::SLUG)->delete();
        DB::table('atom_taxonomies')->where('model_type', 'App\Domains\Service\Models\Service')->delete();

        Schema::dropIfExists('rg_services');
    }
};
