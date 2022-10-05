<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CdpBonusesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\CdpBonusesServiceInterface::class,
            \App\Services\CdpBonusesService::class,
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
