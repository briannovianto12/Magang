<?php

namespace Bromo\Transaction\Providers;

use Config;
use Illuminate\Support\ServiceProvider;

class TransactionServiceProvider extends ServiceProvider
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
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/transaction');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'transaction');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'transaction');
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
            __DIR__ . '/../Config/config.php' => config_path('transaction.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'transaction'
        );

        $this->publishes([
            __DIR__ . '/../Config/shippingv2.php' => config_path('shippingv2.php'),
        ], 'shippingv2');

        $this->mergeConfigFrom(
            __DIR__ . '/../Config/shippingv2.php', 'shippingv2'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/transaction');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/transaction';
        }, Config::get('view.paths')), [$sourcePath]), 'transaction');
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

}
