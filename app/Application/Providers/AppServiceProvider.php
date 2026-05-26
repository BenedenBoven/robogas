<?php

namespace App\Application\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {


    public function boot(): void {
        Schema::defaultStringLength(255);

        Model::preventLazyLoading(!$this->app->isProduction());

        if(!$this->app->isProduction()) {
            $mailer = $this->app->make(Mailer::class);
            $mailer->alwaysTo('ronald@benedenboven.nl');
        }
    }

    public function register(): void {}
}
