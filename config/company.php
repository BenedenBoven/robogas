<?php declare(strict_types=1);

/**
 * De vaste bedrijfsgegevens, als terugval voor de instellingen in Atom.
 *
 * Staat een veld in Atom ingevuld, dan wint dat; zie CompanyDetailsComposer.
 * Zo staat er geen lege regel in de footer zolang niemand de instellingen heeft
 * aangeraakt, en hoeft een verhuizing niet in de code.
 */
return [

    'name' => env('COMPANY_NAME', 'Robo Gascentrale B.V.'),

    'address' => [
        'street'   => 'Gildenstraat 20',
        'postcode' => '3861 RG',
        'city'     => 'Nijkerk',
        'country'  => 'Nederland',
    ],

    'phone' => '033 - 245 25 45',

    'email' => 'info@robogas.nl',

    /** Plaatshouder uit het ontwerp; nog niet door RoboGas bevestigd. */
    'opening_hours' => 'Werkdagen 8.00 - 17.00 uur',

    /**
     * De kaart op de contactpagina: de src van een Google Maps-embed. Werkt
     * zonder API-sleutel. Beter is de embed-url uit Google Maps zelf (Delen,
     * Kaart insluiten), die wijst precies op de vestiging.
     */
    'maps_embed_url' => env('GOOGLE_MAPS_EMBED_URL', 'https://www.google.com/maps?q=Gildenstraat+20,+3861+RG+Nijkerk&hl=nl&z=15&output=embed'),

    /**
     * Het klantportaal Mijn Robogas staat buiten deze website. Zolang er geen
     * adres is ingevuld, gaan de links ernaar naar de contactpagina.
     */
    'portal_url' => env('ROBOGAS_PORTAL_URL'),

];
