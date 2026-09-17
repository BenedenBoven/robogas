<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Hero- en blokvelden voor de vaste pagina's.
     *
     * subtitle en summary zijn de kicker en de intro in de paginaheader.
     * De blokvelden vullen een vaste sectie op de pagina zelf, zoals "Voor wie
     * we het doen" op het dienstenoverzicht. Welke pagina welke velden krijgt,
     * staat in Page::getFillable().
     */
    private const COLUMNS = [
        'subtitle'       => 'string',
        'summary'        => 'text',
        'block_title'    => 'string',
        'block_subtitle' => 'string',
        'block_content'  => 'text',
    ];

    public function up(): void {
        foreach(self::COLUMNS as $column => $type) {
            if(Schema::hasColumn('atom_pages', $column)) {
                continue;
            }

            Schema::table('atom_pages', function(Blueprint $table) use ($column, $type) {
                $table->{$type}($column)->nullable();
            });
        }
    }

    public function down(): void {
        $existing = array_values(array_filter(
            array_keys(self::COLUMNS),
            static fn(string $column) => Schema::hasColumn('atom_pages', $column)
        ));

        if($existing === []) {
            return;
        }

        Schema::table('atom_pages', function(Blueprint $table) use ($existing) {
            $table->dropColumn($existing);
        });
    }
};
