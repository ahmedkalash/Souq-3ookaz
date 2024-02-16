<?php

namespace App\Providers;

use App\Models\User;
use Barryvdh\Debugbar\LaravelDebugbar;
use Gate;
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
        Gate::define('use-translation-manager', function (?User $user) {
            return $user !== null && $user->hasRole('super-admin');
        });
    }
}
