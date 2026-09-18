<?php declare(strict_types=1);

namespace App\Domains\Vacancy\Emails;

use App\Domains\Vacancy\Actions\StoreApplicationFiles;
use BenedenBoven\AtomGenericForms\Entities\Form;
use Illuminate\Mail\Mailable;

/**
 * Een sollicitatie. RoboGas krijgt downloadlinks naar de bestanden; de
 * sollicitant ziet in de bevestiging alleen de bestandsnamen.
 */
final class ApplicationMail extends Mailable {

    /**
     * @param array<string, string|null> $post
     * @param list<string>               $files  namen in storage/vacatures
     */
    public function __construct(
        public array  $post,
        public Form   $form,
        public string $vacancyTitle,
        public array  $files,
        public bool   $toHost,
    ) {}

    public function build(): self {
        return $this->markdown('emails.application')->with([
            'post'         => $this->post,
            'form'         => $this->form,
            'vacancyTitle' => $this->vacancyTitle,
            'toHost'       => $this->toHost,
            'fileLinks'    => array_map(
                static fn(string $file) => [
                    'name' => $file,
                    'url'  => url('/atom/download-bestand/' . StoreApplicationFiles::FOLDER . '/' . rawurlencode($file)),
                ],
                $this->files
            ),
        ]);
    }
}
