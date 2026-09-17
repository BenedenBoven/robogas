<?php declare(strict_types=1);

namespace App\Application\Middleware;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

/**
 * Controleert het reCAPTCHA-token bij Google voordat een formulier verwerkt wordt.
 *
 * Zonder deze controle voegt de captcha niets toe: de bezoeker vult hem in, maar
 * de server keek er niet naar en accepteerde elke inzending.
 *
 * De fout komt terug als validatiefout op het veld 'privacy'. Dat is het laatste
 * veld boven de knop, dus de melding komt in beeld op de plek waar de bezoeker
 * op dat moment kijkt; er is geen eigen veld voor de captcha.
 */
final readonly class VerifyRecaptcha {

    private const ENDPOINT = 'https://www.google.com/recaptcha/api/siteverify';

    public function __construct(
        private Factory    $http,
        private Repository $config
    ) {}

    public function handle(Request $request, $next): mixed {
        $secret = (string)$this->config->get('services.recaptcha.secret');

        // Niet ingesteld: de formulieren blijven werken, alleen zonder captcha.
        // Zo staat een omgeving zonder sleutels niet meteen stil.
        if($secret === '') {
            return $next($request);
        }

        $token = (string)$request->input('g-recaptcha-response');

        if($token === '') {
            $this->fail('De captcha is niet ingevuld. Probeer het opnieuw.');
        }

        try {
            $response = $this->http
                ->asForm()
                ->timeout(5)
                ->post(self::ENDPOINT, [
                    'secret'   => $secret,
                    'response' => $token,
                    'remoteip' => $request->ip(),
                ]);
        } catch(ConnectionException $exception) {
            // Google onbereikbaar: de inzending tegenhouden zou betekenen dat een
            // storing bij hen ons formulier onbruikbaar maakt. Wel loggen.
            Log::warning('reCAPTCHA niet bereikbaar, inzending doorgelaten.', ['melding' => $exception->getMessage()]);

            return $next($request);
        }

        $result = $response->json();

        if(($result['success'] ?? false) !== true) {
            $this->fail('De captcha kon niet gecontroleerd worden. Probeer het opnieuw.');
        }

        // Score is er alleen bij reCAPTCHA v3; bij v2 ontbreekt hij en telt
        // alleen 'success'.
        $score = $result['score'] ?? null;

        if($score !== null && (float)$score < (float)$this->config->get('services.recaptcha.minimal_score')) {
            $this->fail('De inzending is aangemerkt als geautomatiseerd. Neem gerust telefonisch contact op.');
        }

        return $next($request);
    }

    private function fail(string $message): never
    {
        throw ValidationException::withMessages(['privacy' => $message]);
    }
}
