<?php

namespace Modules\ThermalPrinterPro\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class ThermalPrinterProServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('ThermalPrinterPro', 'Database/Migrations'));
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
            module_path('ThermalPrinterPro', 'Config/config.php') => config_path('thermalprinterpro.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('ThermalPrinterPro', 'Config/config.php'), 'thermalprinterpro'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/thermalprinterpro');

        $sourcePath = module_path('ThermalPrinterPro', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/thermalprinterpro';
        }, \Config::get('view.paths')), [$sourcePath]), 'thermalprinterpro');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/thermalprinterpro');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'thermalprinterpro');
        } else {
            $this->loadTranslationsFrom(module_path('ThermalPrinterPro', 'Resources/lang'), 'thermalprinterpro');
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
            app(Factory::class)->load(module_path('ThermalPrinterPro', 'Database/factories'));
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
