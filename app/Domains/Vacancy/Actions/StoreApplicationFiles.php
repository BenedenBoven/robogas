<?php declare(strict_types=1);

namespace App\Domains\Vacancy\Actions;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * Zet de bestanden van een sollicitatie in storage/vacatures. Die map staat
 * buiten public: alleen ingelogd in Atom is een bestand te downloaden, via
 * /atom/download-bestand/vacatures/{bestand}.
 */
final readonly class StoreApplicationFiles {

    public const FOLDER = 'vacatures';

    /**
     * @param list<UploadedFile> $files  al gevalideerd op type en grootte
     * @return list<string>              de nieuwe bestandsnamen
     */
    public function run(array $files): array {
        $names = [];

        foreach($files as $file) {
            // Een willekeurig stuk in de naam: twee keer "cv.pdf" overschrijft
            // elkaar niet, en een naam is niet te raden. De extensie komt uit de
            // inhoud van het bestand, niet uit wat de bezoeker opgaf.
            $base = Str::limit(Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)), 60, '') ?: 'bestand';
            $name = $base . '-' . Str::lower(Str::random(12)) . '.' . ($file->guessExtension() ?? 'bin');

            $file->move(storage_path(self::FOLDER), $name);
            $names[] = $name;
        }

        return $names;
    }
}
