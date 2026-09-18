<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Eén pagina kan nu meer lijsten hebben: Over ons heeft kerncijfers én
     * mijlpalen. De kolom list zegt bij welke lijst een regel hoort (zie
     * StepList); bestaande regels zijn stappen. De kolom label is het korte
     * voorvoegsel dat een stap niet heeft: het getal bij een kerncijfer, het
     * jaartal bij een mijlpaal.
     */
    public function up(): void {
        Schema::table('rg_steps', function(Blueprint $table) {
            $table->string('list', 32)->default('steps')->after('model_id');
            $table->string('label', 32)->nullable()->after('list');

            $table->index(['model_type', 'model_id', 'list']);
        });
    }

    public function down(): void {
        Schema::table('rg_steps', function(Blueprint $table) {
            $table->dropIndex(['model_type', 'model_id', 'list']);
            $table->dropColumn(['list', 'label']);
        });
    }
};
