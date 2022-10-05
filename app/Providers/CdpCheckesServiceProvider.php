<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CdpCheckesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\CdpCheckesServiceInterface::class,
            \App\Services\CdpCheckesService::class,
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
