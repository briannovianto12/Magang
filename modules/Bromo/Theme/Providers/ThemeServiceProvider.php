<?php

namespace Bromo\Theme\Providers;

use Bromo\Theme\Themes;
use Bromo\Theme\ThemeViewFinder;
use Bromo\Theme\Utils\Helper;
use Bromo\Theme\Utils\SnowFlake;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
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
        $this->registerRoutes();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
    }

    public function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/helpers.php');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/theme');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'theme');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'theme');
        }
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/themes.php' => config_path('themes.php'),
        ], 'themes');

        $this->mergeConfigFrom(
            __DIR__ . '/../Config/themes.php', 'themes'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/theme');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $current = themes()->set(Config::get('themes.default'));
        $this->loadViewsFrom("{$sourcePath}/{$current->code}", 'theme');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('themes', function () {
            return new Themes();
        });

        $this->app->singleton('helper', function () {
            return new Helper();
        });

        $this->app->singleton('snowflake', function () {
            return new SnowFlake();
        });

        $this->app->singleton('view.finder', function ($app) {
            return new ThemeViewFinder(
                $app['files'],
                $app['config']['view.paths'],
                null
            );
        });
    }
}
