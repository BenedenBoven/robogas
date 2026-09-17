<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Form\Api;

use App\Support\FormType;
use App\Support\Services\CompanyDetails;
use BenedenBoven\AtomGenericForms\Actions\GetFormByFile;
use BenedenBoven\AtomGenericForms\Actions\ValidateAndSend;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;

/**
 * Verwerkt alle formulieren op de site. Wat per formulier verschilt (bestand,
 * onderwerp, melding) staat in FormType; de vier handlers waren anders kopieën
 * van elkaar.
 *
 * De inzending gaat naar het e-mailadres uit de bedrijfsgegevens, komt in de
 * inbox van Atom, en de bezoeker krijgt een bevestiging.
 */
final readonly class SubmitForm {

    public function __construct(
        private GetFormByFile   $getFormByFile,
        private ValidateAndSend $validateAndSend,
        private ResponseFactory $responseFactory,
        private CompanyDetails  $companyDetails,
    ) {}

    public function __invoke(FormType $formType): JsonResponse {
        $this->validateAndSend->run(
            $this->getFormByFile->run($formType->file()),
            $this->companyDetails->email(),
            $this->companyDetails->name(),
            $formType->subject(),
        );

        return $this->responseFactory->json([
            'message' => $formType->successMessage(),
        ]);
    }
}
