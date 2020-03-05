<?php

namespace App\Providers;

use App\Models\Houseguest;
use App\Observers\HouseguestObserver;
use Illuminate\Support\Collection;
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

        Collection::macro('toAssoc', function () {
            return $this->reduce(static function ($assoc, $keyValuePair) {
                list($key, $value) = $keyValuePair;
                $assoc[$key] = $value;
                return $assoc;
            }, new static);
        });
        Collection::macro('mapToAssoc', function ($callback) {
            return $this->map($callback)->toAssoc();
        });
    }
}
