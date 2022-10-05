<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CdpUserModerationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\CdpUserModerationServiceInterface::class,
            \App\Services\CdpUserModerationService::class
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
