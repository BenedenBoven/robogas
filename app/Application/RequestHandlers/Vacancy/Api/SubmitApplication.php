<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Vacancy\Api;

use App\Domains\Vacancy\Actions\StoreApplicationFiles;
use App\Domains\Vacancy\Contracts\VacancyRepositoryInterface;
use App\Domains\Vacancy\Emails\ApplicationMail;
use App\Support\Services\CompanyDetails;
use BenedenBoven\AtomGenericForms\Actions\GetFormByFile;
use BenedenBoven\AtomGenericForms\Actions\SendEmail;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Verwerkt het sollicitatieformulier op een vacaturepagina.
 *
 * Niet via SubmitForm: de bestanden moeten eerst veilig worden opgeslagen, en
 * de mail aan RoboGas krijgt downloadlinks die de sollicitant niet hoort te
 * zien. De velden, de validatie en de inbox van Atom werken wel hetzelfde.
 */
final readonly class SubmitApplication {

    /** Houd deze gelijk aan de accept en data-attributen in components.form.file-upload. */
    private const FILE_RULES = ['file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'];
    private const MAX_FILES  = 5;

    public function __construct(
        private GetFormByFile              $getFormByFile,
        private SendEmail                  $sendEmail,
        private StoreApplicationFiles      $storeApplicationFiles,
        private VacancyRepositoryInterface $vacancyRepository,
        private CompanyDetails             $companyDetails,
        private ResponseFactory            $responseFactory,
    ) {}

    public function __invoke(Request $request): JsonResponse {
        $form = $this->getFormByFile->run(resource_path('views/forms/application.blade.php'));

        $request->validate([
            ...$form->getValidation(),
            'vacancy_id' => ['required', 'integer'],
            'files'      => ['required', 'array', 'max:' . self::MAX_FILES],
            'files.*'    => self::FILE_RULES,
        ], [
            'files.required' => 'Voeg je cv toe.',
            'files.max'      => 'Je kunt maximaal ' . self::MAX_FILES . ' bestanden meesturen.',
            'files.*.mimes'  => 'Dit bestandstype kan niet. Kies een pdf, Word-bestand of foto.',
            'files.*.max'    => 'Een bestand mag maximaal 10 MB zijn.',
            'files.*.file'   => 'Dit bestand is niet goed aangekomen. Probeer het opnieuw.',
        ]);

        // Het id komt uit een verborgen veld, dus opnieuw opzoeken: alleen een
        // gepubliceerde vacature telt, en de titel komt uit de database.
        $vacancy = $this->vacancyRepository->find((int)$request->input('vacancy_id'));

        if($vacancy === null) {
            // Onder het laatste veld, zoals een captchafout; zie components.form.privacy.
            throw ValidationException::withMessages(['privacy' => 'Deze vacature staat niet meer open. Bel ons gerust.']);
        }

        $files   = $this->storeApplicationFiles->run($request->file('files'));
        $post    = $request->only([...$form->fields, ...$form->textAreas]);
        $subject = 'Sollicitatie: ' . $vacancy->title;

        $this->sendEmail->run(
            (new ApplicationMail($post, $form, $vacancy->title, $files, toHost: true))
                ->from($this->companyDetails->email(), $this->companyDetails->name())
                ->replyTo($post['email'], $post['name'])
                ->subject($subject),
            $this->companyDetails->email(),
            $post['name'],
            $post['email'],
            $subject,
        );

        $this->sendEmail->run(
            mailable: (new ApplicationMail($post, $form, $vacancy->title, $files, toHost: false))
                ->from($this->companyDetails->email(), $this->companyDetails->name())
                ->replyTo($this->companyDetails->email(), $this->companyDetails->name())
                ->subject('Bevestiging: ' . $subject),
            to: $post['email'],
            saveToDatabase: false,
        );

        return $this->responseFactory->json([
            'message' => 'Bedankt voor je sollicitatie! We hebben alles ontvangen en nemen snel contact met je op.',
        ]);
    }
}
