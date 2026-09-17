<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Atom vult bij het aanmaken van een taxonomy een hash_id (zie
     * ModelTrait::createTaxonomy), maar de kolom stond niet in de database.
     * Zonder deze kolom mislukt het aanmaken van elke nieuwe pagina of item.
     */
    public function up(): void {
        if(Schema::hasColumn('atom_taxonomies', 'hash_id')) {
            return;
        }

        Schema::table('atom_taxonomies', function(Blueprint $table) {
            $table->string('hash_id')->nullable()->after('url')->index();
        });
    }

    public function down(): void {
        if(!Schema::hasColumn('atom_taxonomies', 'hash_id')) {
            return;
        }

        Schema::table('atom_taxonomies', function(Blueprint $table) {
            $table->dropIndex(['hash_id']);
            $table->dropColumn('hash_id');
        });
    }
};
