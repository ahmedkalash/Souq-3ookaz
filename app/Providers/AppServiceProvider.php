<?php

namespace App\Providers;

use App\Models\Currency;
use App\Models\User;
use App\Services\ProductPriceService;
use Barryvdh\Debugbar\LaravelDebugbar;
use Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     * @throws \Exception
     */
    public function register()
    {
        $this->registerProductPriceServiceProperties();
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

        if(\Schema::hasTable(Currency::tableName())) {
            View::share('supported_currencies', Currency::get('code'));
        }
    }

    /**
     * @throws \Exception
     */
    public function registerProductPriceServiceProperties()
    {
        ProductPriceService::setCurrencyModelClass(Currency::class);
    }
}
