<?php

namespace App\Application\Providers;

use App\Infrastructure\Attributes\ComposesViews;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Factory;
use ReflectionClass;

final class ComposerServiceProvider extends ServiceProvider {

    public function boot(): void {}

    public function register(): void {
        /** @var Factory $viewFactory */
        $viewFactory = Container::getInstance()->make(Factory::class);

        $this->registerComposersFromAttributes($viewFactory);
    }

    private function registerComposersFromAttributes(Factory $viewFactory): void {
        $composerPath = app_path('Infrastructure/ViewComposers');

        $composerClasses = $this->getComposerClasses($composerPath);

        foreach($composerClasses as $composerClass) {
            // Bind composer as scoped (singleton per request)
            $this->app->scoped($composerClass);

            $reflection = new ReflectionClass($composerClass);
            $attributes = $reflection->getAttributes(ComposesViews::class);

            foreach($attributes as $attribute) {
                /** @var ComposesViews $instance */
                $instance = $attribute->newInstance();

                foreach($instance->views as $view) {
                    $viewFactory->composer($view, $composerClass);
                }
            }
        }
    }

    private function getComposerClasses(string $path, string $baseNamespace = 'App\\Infrastructure\\ViewComposers'): array {
        $classes = [];
        $files   = glob($path . '/*');

        foreach($files as $file) {
            if(is_dir($file)) {
                $subNamespace = $baseNamespace . '\\' . basename($file);
                $classes      = array_merge($classes, $this->getComposerClasses($file, $subNamespace));
            } elseif(pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $className = $baseNamespace . '\\' . basename($file, '.php');

                if(class_exists($className) &&
                    basename($file) !== 'AbstractMemoizedComposer.php') {
                    $classes[] = $className;
                }
            }
        }

        return $classes;
    }
}