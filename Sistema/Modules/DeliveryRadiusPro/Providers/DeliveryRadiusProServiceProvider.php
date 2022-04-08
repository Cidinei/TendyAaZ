<?php

namespace Modules\DeliveryRadiusPro\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class DeliveryRadiusProServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('DeliveryRadiusPro', 'Database/Migrations'));
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
            module_path('DeliveryRadiusPro', 'Config/config.php') => config_path('deliveryradiuspro.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('DeliveryRadiusPro', 'Config/config.php'), 'deliveryradiuspro'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/deliveryradiuspro');

        $sourcePath = module_path('DeliveryRadiusPro', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/deliveryradiuspro';
        }, \Config::get('view.paths')), [$sourcePath]), 'deliveryradiuspro');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/deliveryradiuspro');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'deliveryradiuspro');
        } else {
            $this->loadTranslationsFrom(module_path('DeliveryRadiusPro', 'Resources/lang'), 'deliveryradiuspro');
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
            app(Factory::class)->load(module_path('DeliveryRadiusPro', 'Database/factories'));
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
