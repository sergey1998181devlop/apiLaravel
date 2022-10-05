<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CdpAdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\CdpAdminServiceInterface::class,
            \App\Services\CdpAdminService::class
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
