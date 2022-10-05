<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CdpDrawServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\CdpDrawServiceInterface::class,
            \App\Services\CdpDrawService::class
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
