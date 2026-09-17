<?php declare(strict_types=1);

namespace App\Support\Services;

use BenedenBoven\Atom\Modules\Setting\Models\Settings;

/**
 * De bedrijfsgegevens: eerst uit de instellingen in Atom, anders uit
 * config/company.php.
 *
 * Eén plek, omdat dezelfde gegevens in de footer, op de contactpagina en als
 * ontvanger van de formulieren nodig zijn.
 */
final readonly class CompanyDetails {

    public function name(): string {
        return $this->setting('general.companyname', (string)config('company.name'));
    }

    public function street(): string {
        return $this->setting('contact.street', (string)config('company.address.street'));
    }

    public function postcode(): string {
        return $this->setting('contact.postcode', (string)config('company.address.postcode'));
    }

    public function city(): string {
        return $this->setting('contact.city', (string)config('company.address.city'));
    }

    public function country(): string {
        return (string)config('company.address.country');
    }

    public function phone(): string {
        return $this->setting('contact.phone', (string)config('company.phone'));
    }

    /**
     * Een tel:-link uit het geschreven nummer, zodat het nummer maar op één plek
     * staat. Een Nederlands nummer met kengetal wordt internationaal: de nul
     * vervalt en +31 komt ervoor. Bij "+31 (0)33" moet de nul tussen haakjes
     * weg, anders ontstaat +31033.
     */
    public function phoneHref(): string {
        $phone = trim($this->phone());

        if(str_starts_with($phone, '+')) {
            return 'tel:' . preg_replace('/[^0-9+]/', '', preg_replace('/\(\s*0\s*\)/', '', $phone) ?? $phone);
        }

        $digits = preg_replace('/\D/', '', $phone) ?? '';

        return 'tel:' . (str_starts_with($digits, '0') ? '+31' . substr($digits, 1) : $digits);
    }

    public function email(): string {
        return $this->setting('contact.email', (string)config('company.email'));
    }

    public function openingHours(): string {
        return (string)config('company.opening_hours');
    }

    public function mapsEmbedUrl(): string {
        return (string)config('company.maps_embed_url');
    }

    public function portalUrl(): ?string {
        $url = config('company.portal_url');

        return is_string($url) && $url !== '' ? $url : null;
    }

    /** Een instelling die bestaat maar leeg is, telt als niet ingevuld. */
    private function setting(string $key, string $default): string {
        $value = Settings::get($key);

        return is_string($value) && trim($value) !== '' ? trim($value) : $default;
    }
}
