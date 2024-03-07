<?php

namespace App\Providers;

use App\Http\Interfaces\CartInterface;
use App\Http\Interfaces\Web\Customer\Auth\LoginInterface;
use App\Http\Interfaces\Web\Customer\Auth\RegisterInterface;
use App\Http\Interfaces\Web\Customer\Auth\ResetPasswordInterface;
use App\Http\Interfaces\Web\Customer\Auth\SocialAuthInterface;
use App\Http\Interfaces\Web\Customer\ProductInterface;
use App\Http\Repositories\CartRepository;
use App\Http\Repositories\Web\Customer\Auth\LoginRepository;
use App\Http\Repositories\Web\Customer\Auth\RegisterRepository;
use App\Http\Repositories\Web\Customer\Auth\ResetPasswordRepository;
use App\Http\Repositories\Web\Customer\Auth\SocialAuthRepository;
use App\Http\Repositories\Web\Customer\ProductRepository;
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
        $this->app->bind(ResetPasswordInterface::class, ResetPasswordRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(CartInterface::class, CartRepository::class);
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
