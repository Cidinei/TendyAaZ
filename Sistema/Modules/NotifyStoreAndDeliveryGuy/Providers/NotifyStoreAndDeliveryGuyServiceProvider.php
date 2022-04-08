<?php

namespace Modules\NotifyStoreAndDeliveryGuy\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class NotifyStoreAndDeliveryGuyServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('NotifyStoreAndDeliveryGuy', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('NotifyStoreAndDeliveryGuy', 'Config/config.php') => config_path('notifystoreanddeliveryguy.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('NotifyStoreAndDeliveryGuy', 'Config/config.php'), 'notifystoreanddeliveryguy'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/notifystoreanddeliveryguy');

        $sourcePath = module_path('NotifyStoreAndDeliveryGuy', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/notifystoreanddeliveryguy';
        }, \Config::get('view.paths')), [$sourcePath]), 'notifystoreanddeliveryguy');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/notifystoreanddeliveryguy');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'notifystoreanddeliveryguy');
        } else {
            $this->loadTranslationsFrom(module_path('NotifyStoreAndDeliveryGuy', 'Resources/lang'), 'notifystoreanddeliveryguy');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('NotifyStoreAndDeliveryGuy', 'Database/factories'));
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
