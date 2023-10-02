<?php

namespace App\Http\Repositories\Web\Customer\Auth;
use App\Http\Interfaces\Web\Customer\Auth\LoginInterface;
use App\Http\Repositories\Traits\AuthenticateUserTrait;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginRepository  implements LoginInterface
{
    use AuthenticateUserTrait;


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect(RouteServiceProvider::home());
    }
}

