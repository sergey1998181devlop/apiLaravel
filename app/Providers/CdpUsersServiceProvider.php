<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CdpUsersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\CdpUsersServiceInterface::class,
            \App\Services\CdpUsersService::class
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
