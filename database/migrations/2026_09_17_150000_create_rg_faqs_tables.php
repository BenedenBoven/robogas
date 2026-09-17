<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Veelgestelde vragen, gegroepeerd in thema's.
     *
     * De FAQ-pagina toont alle thema's; een formulierpagina toont het thema dat
     * erbij hoort ("Bestellen" onder Gas bestellen). Welke pagina's een thema
     * tonen kies je bij het thema, zodat het paginaformulier niet voor elke
     * pagina een keuzelijst met thema's krijgt.
     *
     * De vraag staat in title, het antwoord in body, zodat er opmaak en een
     * link in kan.
     */
    public function up(): void {
        Schema::create('rg_faq_themes', function(Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('priority')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        Schema::create('rg_faq_themes_pages', function(Blueprint $table) {
            $table->foreignId('faq_theme_id')->constrained('rg_faq_themes')->cascadeOnDelete();
            $table->foreignId('page_id')->constrained('atom_pages')->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['faq_theme_id', 'page_id']);
        });

        Schema::create('rg_faqs', function(Blueprint $table) {
            $table->id();
            $table->foreignId('faq_theme_id')->constrained('rg_faq_themes')->cascadeOnDelete();
            $table->string('title');
            $table->longText('body')->nullable();
            $table->integer('priority')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        $themesId = $this->createModule('faq-themas', 'FAQ-thema', "FAQ-thema's", 'App\Domains\Faq\Models\FaqTheme', 'fa-regular fa-folder');
        $faqsId   = $this->createModule('veelgestelde-vragen', 'Veelgestelde vraag', 'Veelgestelde vragen', 'App\Domains\Faq\Models\Faq', 'fa-regular fa-circle-question');

        $this->addToAdminMenu($faqsId, 'doelgroepen');
        $this->addToAdminMenu($themesId, 'veelgestelde-vragen');
    }

    private function createModule(string $slug, string $singular, string $plural, string $model, string $icon): int {
        return DB::table('atom_modules')->insertGetId([
            'slug'                    => $slug,
            'creates_taxonomy'        => 0,
            'title_singular'          => $singular,
            'title_plural'            => $plural,
            'model'                   => $model,
            'allow_children'          => 0,
            'default_parent_id'       => '0',
            'controller'              => 'GenericController',
            'blade_folder'            => 'generic',
            'icon'                    => $icon,
            'benedenboven_group_only' => 0,
            'in_menu'                 => 1,
            'organizable'             => 1,
            'publishable'             => 1,
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);
    }

    /**
     * Een module verschijnt pas in het beheermenu als er ook een rij in
     * atom_admin_navigation staat.
     */
    private function addToAdminMenu(int $moduleId, string $afterSlug): void {
        $afterId = DB::table('atom_modules')->where('slug', $afterSlug)->value('id');
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
        foreach(['veelgestelde-vragen', 'faq-themas'] as $slug) {
            $moduleId = DB::table('atom_modules')->where('slug', $slug)->value('id');

            if($moduleId !== null) {
                $prio = DB::table('atom_admin_navigation')->where('module_id', $moduleId)->value('prio');

                DB::table('atom_admin_navigation')->where('module_id', $moduleId)->delete();

                if($prio !== null) {
                    DB::table('atom_admin_navigation')->where('prio', '>', $prio)->decrement('prio');
                }
            }

            DB::table('atom_modules')->where('slug', $slug)->delete();
        }

        Schema::dropIfExists('rg_faqs');
        Schema::dropIfExists('rg_faq_themes_pages');
        Schema::dropIfExists('rg_faq_themes');
    }
};
