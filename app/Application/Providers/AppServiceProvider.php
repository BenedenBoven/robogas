<?php declare(strict_types=1);

namespace App\Application\Providers;

use App\Domains\Page\Contracts\PageRepositoryInterface;
use App\Domains\Page\Repositories\PageRepository;
use App\Domains\Service\Contracts\ServiceRepositoryInterface;
use App\Domains\Service\Repositories\ServiceRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    private const REPOSITORIES = [
        PageRepositoryInterface::class    => PageRepository::class,
        ServiceRepositoryInterface::class => ServiceRepository::class,
    ];


    public function boot(): void {
        Schema::defaultStringLength(255);

        Model::preventLazyLoading(!$this->app->isProduction());

        if(!$this->app->isProduction()) {
            $mailer = $this->app->make(Mailer::class);
            $mailer->alwaysTo('ronald@benedenboven.nl');
        }
    }

    public function register(): void {
        foreach(self::REPOSITORIES as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }
}
