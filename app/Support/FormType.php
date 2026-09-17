<?php declare(strict_types=1);

namespace App\Support;

/**
 * De formulieren op de site. De waarde staat in de url van de API-route:
 * /api/forms/{formType}.
 */
enum FormType: string {

    case CONTACT     = 'contact';
    case ORDER       = 'order';
    case QUOTE       = 'quote';
    case MALFUNCTION = 'malfunction';

    /** Het bestand met de formulierdefinitie bovenin; zie GetFormByFile. */
    public function file(): string {
        return resource_path('views/forms/' . $this->value . '.blade.php');
    }

    public function subject(): string {
        return match ($this) {
            self::CONTACT     => 'Inzending van het contactformulier',
            self::ORDER       => 'Gasbestelling via de website',
            self::QUOTE       => 'Offerteaanvraag via de website',
            self::MALFUNCTION => 'Storingsmelding via de website',
        };
    }

    public function successMessage(): string {
        return match ($this) {
            self::ORDER       => 'Bedankt, we hebben je bestelling ontvangen. We bevestigen de leverdatum per e-mail.',
            self::MALFUNCTION => 'Bedankt, we hebben je melding ontvangen en nemen zo snel mogelijk contact met je op. Ruik je gas? Bel ons dan direct.',
            default           => 'Bedankt, we hebben je bericht ontvangen. We nemen zo snel mogelijk contact met je op.',
        };
    }
}
