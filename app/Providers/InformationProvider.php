<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Services\InformationService;
use App\Repositories\Interfaces\InformationInterface;

class InformationProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(InformationInterface::class, InformationService::class);
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
