<?php

namespace Nbs\BaseResource\Providers;

use Illuminate\Support\ServiceProvider;
use Nbs\BaseResource\Services\FirebaseService;

class FirebaseServiceProvider extends ServiceProvider
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
        $this->app->singleton('firebase', function ($app) {
            return new FirebaseService($app, $app['config']['fcm']);
        });
    }
}
