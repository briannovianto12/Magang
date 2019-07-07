<?php

namespace Nbs\BaseResource\Providers;

use Illuminate\Support\ServiceProvider;
use Nbs\BaseResource\Utils\SnowFlake;

class BaseResourceServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__ . '/../Http/helpers.php';

        $this->registerConfig();
        $this->registerTranslations();
        $this->registerViews();
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/base-resource');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'base-resource');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'base-resource');
        }
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/base-resource');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/base-resource';
        }, \Config::get('view.paths')), [$sourcePath]), 'base-resource');
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/fcm.php' => config_path('fcm.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/fcm.php', 'fcm'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('snowflake', function () {
            return new SnowFlake();
        });
    }
}
