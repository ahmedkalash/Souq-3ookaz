<?php

namespace App\Http\Repositories\Web\Customer\Auth;
use App\Http\Interfaces\CartInterface;
use App\Http\Interfaces\Web\Customer\Auth\LoginInterface;
use App\Http\Repositories\CartRepository;
use App\Http\Traits\AuthenticateUserTrait;
use App\Models\CartItem;
use App\Providers\RouteServiceProvider;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginRepository  implements LoginInterface
{
    use AuthenticateUserTrait;

    protected RateLimiter $rateLimiter;

    public function __construct(RateLimiter $rateLimiter)
    {
        $this->rateLimiter = $rateLimiter;
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect(RouteServiceProvider::home());
    }

    public function beforeSendingSuccessfulLoginResponseHook()
    {
        app(CartInterface::class)::handelShoppingCartAfterLogin();
    }

}

