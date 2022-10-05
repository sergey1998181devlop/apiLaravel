<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class QrCodeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\QrCodeServiceInterface::class,
            \App\Services\QrCodeService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
