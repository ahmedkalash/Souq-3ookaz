<?php

namespace App\Http\Repositories\Traits;

use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

trait AuthenticateUserTrait
{
    public function showLoginPage(){
        return view('customer.auth.login');
    }

    public function authenticate(LoginRequest $request){

        $credentials = $this->credentials($request);

        app()->call([$this,'beforeLoginAttemptHook']);

        if($this->attempt($credentials, $request, $this->rememberMe($request)) ){
            app()->call([$this,'beforeSendingSuccessfulLoginResponseHook']);
            return $this->successfulLoginResponse();
        }else {
            app()->call([$this,'beforeSendingFailedLoginResponseHook']);
            return  $this->failedLoginResponse();
        }



    }


    public function credentials(LoginRequest $request)
    {
        return $request->only(['email','password']);
    }

    public function attempt(array $credentials, LoginRequest $request, bool $rememberMe)
    {
        return Auth::attempt($credentials, $rememberMe);
    }

    public function rememberMe(LoginRequest $request )
    {
        return (bool)$request->remember_me;
    }

    public function successfulLoginResponse()
    {
        return redirect(RouteServiceProvider::home());
    }

    public function failedLoginResponse()
    {
        return  redirect()->back()->withErrors(['login_failed'=>'Invalid Credentials']);
    }

    public function beforeLoginAttemptHook(){
        //
    }
    public function beforeSendingSuccessfulLoginResponseHook(){
         //
    }

    public function beforeSendingFailedLoginResponseHook(){
         //
    }

}
