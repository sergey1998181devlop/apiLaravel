<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CdpSmsSenderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\CdpSmsSenderServiceInterface::class,
            \App\Services\CdpSmsSenderService::class,
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
