<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Contact\Api;

use BenedenBoven\AtomGenericForms\Actions\GetFormByFile;
use BenedenBoven\AtomGenericForms\Actions\ValidateAndSend;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;

final readonly class SubmitContactForm {

    public function __construct(
        private GetFormByFile   $getFormByFile,
        private ValidateAndSend $validateAndSend,
        private ResponseFactory $responseFactory,
    ) {}

    public function __invoke(): JsonResponse {
        $form = $this->getFormByFile->run(
            resource_path('views/forms/contact.blade.php')
        );

        $this->validateAndSend->run(
            $form,
            'info@' . env('APP_URL', 'domein.nl'),
            env('APP_NAME', 'Naam klant'),
            'Inzending van het contactformulier',
            false
        );

        return $this->responseFactory->json([
            'message' => 'Bedankt voor je bericht. Het formulier is succesvol verzonden. We nemen (indien nodig) zo snel mogelijk contact met je op.',
        ]);
    }

}