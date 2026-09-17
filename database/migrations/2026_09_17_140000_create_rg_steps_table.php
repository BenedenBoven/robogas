<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Genummerde stappen op een pagina: "wat er hierna gebeurt" onder een
     * formulier, of de noodstappen bij een storing. Overgenomen van Van Lee.
     *
     * Polymorf, zodat een module later ook stappen kan krijgen zonder
     * schemawijziging. Geen nummerkolom: het nummer volgt uit de volgorde.
     */
    public function up(): void {
        Schema::create('rg_steps', function(Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->string('title');
            $table->text('summary')->nullable();
            $table->integer('prio')->default(0);
            $table->timestamps();

            $table->index(['model_type', 'model_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('rg_steps');
    }
};
