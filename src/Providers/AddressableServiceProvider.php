<?php

declare(strict_types=1);

namespace NunoMazer\Addressable\Providers;

use NunoMazer\Addressable\Models\Address;
use Illuminate\Support\ServiceProvider;

class AddressableServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/addressable.php'), 'addressable');

        // Bind eloquent models to IoC container
        $this->app->singleton('addressable.address', $addressModel = $this->app['config']['addressable.models.address']);
        $addressModel === Address::class || $this->app->alias('addressable.address', Address::class);

    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        // Publish Resources
        $this->publishesConfig('nunomazer/laravel-addressable');
        $this->publishesMigrations('nunomazer/laravel-addressable');
        ! $this->autoloadMigrations('nunomazer/laravel-addressable') || $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}
