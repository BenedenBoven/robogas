<?php declare(strict_types=1);

use App\Support\TaxonomyMap;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Kennisartikelen voor Onze kennis, met een eigen themalijst.
     *
     * De labels op een artikel zijn de doelgroepen uit Voor wie, zodat een
     * doelgroeppagina later de artikelen voor die doelgroep kan tonen. Een
     * artikel zonder foto krijgt op zijn kaart een kleur uit de huisstijl.
     */
    public function up(): void {
        Schema::create('rg_article_themes', function(Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('priority')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        Schema::create('rg_articles', function(Blueprint $table) {
            $table->id();
            $table->foreignId('article_theme_id')->nullable()->constrained('rg_article_themes')->nullOnDelete();
            $table->string('title');
            $table->text('summary')->nullable();
            $table->longText('body')->nullable();
            $table->unsignedBigInteger('header_id')->nullable();
            $table->enum('color', ['blauw', 'geel', 'navy'])->default('blauw')->comment('Kaartkleur als er geen headerbeeld is');
            $table->integer('priority')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        Schema::create('rg_articles_audiences', function(Blueprint $table) {
            $table->foreignId('article_id')->constrained('rg_articles')->cascadeOnDelete();
            $table->foreignId('audience_id')->constrained('rg_audiences')->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['article_id', 'audience_id']);
        });

        $articlesId = $this->createModule('kennisartikelen', 1, 'Kennisartikel', 'Kennisartikelen', 'App\Domains\Article\Models\Article', 'fa-regular fa-lightbulb', (string)TaxonomyMap::KNOWLEDGE->value);
        $themesId   = $this->createModule('kennisthemas', 0, 'Kennisthema', "Kennisthema's", 'App\Domains\Article\Models\ArticleTheme', 'fa-regular fa-tags', '0');

        $this->addToAdminMenu($articlesId, 'doelgroepen');
        $this->addToAdminMenu($themesId, 'kennisartikelen');
    }

    private function createModule(string $slug, int $createsTaxonomy, string $singular, string $plural, string $model, string $icon, string $parent): int {
        return DB::table('atom_modules')->insertGetId([
            'slug'                    => $slug,
            'creates_taxonomy'        => $createsTaxonomy,
            'title_singular'          => $singular,
            'title_plural'            => $plural,
            'model'                   => $model,
            'allow_children'          => 0,
            'default_parent_id'       => $parent,
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
        foreach(['kennisthemas', 'kennisartikelen'] as $slug) {
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

        DB::table('atom_taxonomies')->where('model_type', 'App\Domains\Article\Models\Article')->delete();

        Schema::dropIfExists('rg_articles_audiences');
        Schema::dropIfExists('rg_articles');
        Schema::dropIfExists('rg_article_themes');
    }
};
