<?php declare(strict_types=1);

use App\Support\TaxonomyMap;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private const SLUG = 'vacatures';

    /**
     * Vacatures, elk met een eigen pagina onder Vacatures. Het aantal
     * gepubliceerde vacatures staat als teller in het menu.
     *
     * Uren en standplaats zijn losse velden, zodat de lijst ze naast de titel
     * kan tonen zonder dat de redactie ze in de tekst moet herhalen.
     */
    public function up(): void {
        Schema::create('rg_vacancies', function(Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('hours')->nullable()->comment('Bijvoorbeeld: 32 - 38 uur');
            $table->string('location')->nullable()->comment('Bijvoorbeeld: Nijkerk');
            $table->text('summary')->nullable();
            $table->longText('body')->nullable();
            $table->unsignedBigInteger('header_id')->nullable();
            $table->integer('priority')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        $moduleId = DB::table('atom_modules')->insertGetId([
            'slug'                    => self::SLUG,
            'creates_taxonomy'        => 1,
            'title_singular'          => 'Vacature',
            'title_plural'            => 'Vacatures',
            'model'                   => 'App\Domains\Vacancy\Models\Vacancy',
            'allow_children'          => 0,
            'default_parent_id'       => (string)TaxonomyMap::CAREERS->value,
            'controller'              => 'GenericController',
            'blade_folder'            => 'generic',
            'icon'                    => 'fa-regular fa-briefcase',
            'benedenboven_group_only' => 0,
            'in_menu'                 => 1,
            'organizable'             => 1,
            'publishable'             => 1,
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);

        $afterId = DB::table('atom_modules')->where('slug', 'faq-themas')->value('id');
        $after   = $afterId ? DB::table('atom_admin_navigation')->where('module_id', $afterId)->first() : null;
        $prio    = $after ? $after->prio + 1 : (int)DB::table('atom_admin_navigation')->max('prio') + 1;

        DB::table('atom_admin_navigation')->where('prio', '>=', $prio)->increment('prio');
        DB::table('atom_admin_navigation')->insert(['module_id' => $moduleId, 'title' => '', 'prio' => $prio, 'created_at' => now(), 'updated_at' => now()]);
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
        DB::table('atom_taxonomies')->where('model_type', 'App\Domains\Vacancy\Models\Vacancy')->delete();

        Schema::dropIfExists('rg_vacancies');
    }
};
