<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CdpProductsCatalogServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\CdpCatalogServiceInterface::class,
            \App\Services\CdpProductsCatalogService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('cdpProductsCatalog', \App\Services\CdpProductsCatalogService::class);
    }
}
