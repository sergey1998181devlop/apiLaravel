<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CdpProductsCategoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\CdpProductsCategoriesServiceInterface::class,
            \App\Services\CdpProductsCategoriesService::class,
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
