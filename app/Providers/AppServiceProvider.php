<?php

namespace App\Providers;

use App\Models\Houseguest;
use App\Observers\HouseguestObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Houseguest::observe(HouseguestObserver::class);
    }
}
