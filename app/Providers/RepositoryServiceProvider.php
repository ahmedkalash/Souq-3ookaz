<?php

namespace App\Providers;

use App\Http\Controllers\Web\Customer\Auth\SocialAuthController;
use App\Http\Interfaces\Web\Customer\Auth\LoginInterface;
use App\Http\Interfaces\Web\Customer\Auth\RegisterInterface;
use App\Http\Interfaces\Web\Customer\Auth\SocialAuthInterface;
use App\Http\Repositories\Web\Customer\Auth\LoginRepository;
use App\Http\Repositories\Web\Customer\Auth\RegisterRepository;
use App\Http\Repositories\Web\Customer\Auth\SocialAuthRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RegisterInterface::class, RegisterRepository::class);
        $this->app->bind(LoginInterface::class, LoginRepository::class);
        $this->app->bind(SocialAuthInterface::class, SocialAuthRepository::class);

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
