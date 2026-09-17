<?php declare(strict_types=1);

namespace App\Atom\Steps\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Stelt de beheerweergave van de stappen beschikbaar onder de namespace
 * atom-steps, zodat getExtraAtomTabs() ernaar kan verwijzen.
 *
 * Geen routes: het opslaan loopt mee met het gewone formulier van Atom.
 */
final class StepAtomProvider extends ServiceProvider {

    public function boot(): void {
        $this->loadViewsFrom(__DIR__ . '/../Views', 'atom-steps');
    }
}
