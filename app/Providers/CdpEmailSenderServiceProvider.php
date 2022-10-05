<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CdpEmailSenderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\CdpEmailSenderServiceInterface::class,
            \App\Services\CdpEmailSenderService::class,
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


