<?php declare(strict_types=1);

use App\Support\TaxonomyMap;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private const SLUG = 'doelgroepen';

    /**
     * Doelgroepen: particulier, agrarisch, recreatie en zo verder.
     *
     * Het icoon is een keuze uit de zes lijntekeningen in de huisstijl; nieuwe
     * iconen in die stijl tekenen we niet zelf. benefits en uses zijn
     * opsommingen met één punt per regel.
     *
     * De koppeling met diensten staat op beide formulieren, dus één koppeltabel
     * die beide modellen gebruiken.
     */
    public function up(): void {
        Schema::create('rg_audiences', function(Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('long_title')->nullable()->comment('Kop op de pagina. Leeg: de titel.');
            $table->enum('icon', ['particulier', 'agrarisch', 'ballonvaart', 'recreatie', 'heftrucks', 'bouw-industrie'])->default('particulier');
            $table->text('summary')->nullable();
            $table->text('benefits')->nullable()->comment('Eén punt per regel');
            $table->text('uses')->nullable()->comment('Eén punt per regel');
            $table->longText('body')->nullable();
            $table->unsignedBigInteger('header_id')->nullable();
            $table->integer('priority')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        Schema::create('rg_audiences_services', function(Blueprint $table) {
            $table->foreignId('audience_id')->constrained('rg_audiences')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('rg_services')->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['audience_id', 'service_id']);
        });

        $moduleId = DB::table('atom_modules')->insertGetId([
            'slug'                    => self::SLUG,
            'creates_taxonomy'        => 1,
            'title_singular'          => 'Doelgroep',
            'title_plural'            => 'Doelgroepen',
            'model'                   => 'App\Domains\Audience\Models\Audience',
            'allow_children'          => 0,
            'default_parent_id'       => (string)TaxonomyMap::AUDIENCES->value,
            'controller'              => 'GenericController',
            'blade_folder'            => 'generic',
            'icon'                    => 'fa-regular fa-users',
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
     * atom_admin_navigation staat. Doelgroepen komen direct na Diensten.
     */
    private function addToAdminMenu(int $moduleId): void {
        $afterId = DB::table('atom_modules')->where('slug', 'diensten')->value('id');
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
        DB::table('atom_taxonomies')->where('model_type', 'App\Domains\Audience\Models\Audience')->delete();

        Schema::dropIfExists('rg_audiences_services');
        Schema::dropIfExists('rg_audiences');
    }
};
