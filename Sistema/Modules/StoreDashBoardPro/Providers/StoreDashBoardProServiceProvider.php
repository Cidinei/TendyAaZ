<?php

namespace Modules\StoreDashBoardPro\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class StoreDashBoardProServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('StoreDashBoardPro', 'Database/Migrations'));
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
            module_path('StoreDashBoardPro', 'Config/config.php') => config_path('storedashboardpro.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('StoreDashBoardPro', 'Config/config.php'), 'storedashboardpro'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/storedashboardpro');

        $sourcePath = module_path('StoreDashBoardPro', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/storedashboardpro';
        }, \Config::get('view.paths')), [$sourcePath]), 'storedashboardpro');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/storedashboardpro');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'storedashboardpro');
        } else {
            $this->loadTranslationsFrom(module_path('StoreDashBoardPro', 'Resources/lang'), 'storedashboardpro');
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
            app(Factory::class)->load(module_path('StoreDashBoardPro', 'Database/factories'));
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
