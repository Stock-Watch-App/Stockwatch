<?php

namespace App\Providers;

use App\Models\Bank;
use App\Models\Houseguest;
use App\Models\Price;
use App\Models\Rating;
use App\Models\Season;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Bank::class => \App\Policies\Bank::class,
        Houseguest::class => \App\Policies\Houseguest::class,
        Price::class => \App\Policies\Price::class,
        Rating::class => \App\Policies\Rating::class,
        Season::class => \App\Policies\Season::class,
        Stock::class => \App\Policies\Stock::class,
        Transaction::class => \App\Policies\Transaction::class,
        User::class => \App\Policies\User::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(static function ($user, $ability) {
            return $user->hasRole('super admin') || env('APP_ENV') === 'local' ? true : null;
        });
    }
}
