<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CdpOrderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\CdpOrderServiceInterface::class,
            \App\Services\CdpOrderService::class
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
