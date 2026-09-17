<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * hash_id was alleen nodig omdat Atom t/m v5.0.0 er in seeders naar schreef,
     * een restant van een teruggedraaide functie uit 2023. Niets leest de kolom.
     *
     * Pas draaien als het project een Atom-versie gebruikt met de fix in
     * ModelTrait; anders faalt een seeder die een taxonomy aanmaakt weer.
     */
    public function up(): void {
        if(!Schema::hasColumn('atom_taxonomies', 'hash_id')) {
            return;
        }

        Schema::table('atom_taxonomies', function(Blueprint $table) {
            $table->dropIndex(['hash_id']);
            $table->dropColumn('hash_id');
        });
    }

    public function down(): void {
        if(Schema::hasColumn('atom_taxonomies', 'hash_id')) {
            return;
        }

        Schema::table('atom_taxonomies', function(Blueprint $table) {
            $table->string('hash_id')->nullable()->after('url')->index();
        });
    }
};
