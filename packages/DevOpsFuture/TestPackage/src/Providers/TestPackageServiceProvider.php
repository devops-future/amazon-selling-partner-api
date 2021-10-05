<?php

namespace DevOpsFuture\TestPackage\Providers;

use DevOpsFuture\TestPackage\Console\Commands\FeedChecher;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class TestPackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->register(ModuleServiceProvider::class);

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Http/admin-routes.php');

        $this->loadRoutesFrom(__DIR__ . '/../Http/portal-routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'testpackage');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('themes/default/assets'),
        ], 'public');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'testpackage');

        Event::listen('bagisto.admin.layout.head', function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('testpackage::admin.layouts.style');
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();

        $this->registerCommands();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php', 'acl'
        );
    }

    /**
     * Register the console commands of this package
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FeedChecher::class,
            ]);
        }
    }
}
