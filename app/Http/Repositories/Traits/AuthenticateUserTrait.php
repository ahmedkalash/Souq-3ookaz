<?php

namespace App\Http\Repositories\Traits;

use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

trait AuthenticateUserTrait
{
    public function showLoginPage(){
        return view('customer.auth.login');
    }

    public function authenticate(LoginRequest $request){

        $credentials = $this->credentials($request);

        app()->call([$this,'beforeLoginAttemptHook']);

        if($this->attempt($credentials, $request) ){
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

    public function attempt(array $credentials, LoginRequest $request)
    {
        return Auth::attempt($credentials,$request->remember_me??false);

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
