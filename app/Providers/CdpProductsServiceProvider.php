<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CdpProductsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\CdpProductsServiceInterface::class,
            \App\Services\CdpProductsService::class,
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
