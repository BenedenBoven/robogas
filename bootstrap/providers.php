<?php

return [
    App\Application\Providers\AppServiceProvider::class,
    App\Application\Providers\ComposerServiceProvider::class,
    App\Atom\Steps\Providers\StepAtomProvider::class,
    Cartalyst\Sentinel\Laravel\SentinelServiceProvider::class,
    Intervention\Image\ImageServiceProvider::class
];