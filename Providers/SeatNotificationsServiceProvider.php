<?php

namespace Neodork\SeatNotifications\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Neodork\SeatNotifications\Console\CreateNotificationCharacterCommand;
use Neodork\SeatNotifications\Console\NotificationsCommand;

class SeatNotificationsServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->addRoutes();
        $this->registerTranslations();
        $this->registerConfig();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->commands([
            NotificationsCommand::class,
        ]);
    }

    /**
     * Include the routes.
     */
    public function addRoutes()
    {

        if (! $this->app->routesAreCached()) {
            include __DIR__ . '/../Http/routes.php';
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('seatnotifications.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'seatnotifications'
        );
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/seatnotifications');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'seatnotifications');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'seatnotifications');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
