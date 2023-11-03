<?php

namespace App\Http\Traits;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait AuthenticateUserTrait
{
    use ThrottleFailedLoginsTrait;
    public function showLoginPage(){
        return view('customer.auth.login');
    }

    public function authenticate(Request $request){

        $credentials = $this->credentials($request);

        app()->call([$this,'beforeLoginAttemptHook']);

        if($this->checkIfUserIsTemporaryBlocked($request)){
            return  $this->tooManyFailedLoginAttemptsResponse($request);
        }

        if($this->attempt($credentials, $request, $this->rememberMe($request)) ){

            $this->clearFailedLoginAttemptsTraking($request);

            app()->call([$this,'beforeSendingSuccessfulLoginResponseHook']);

            return $this->successfulLoginResponse();

        }else {

            $this->incrementFailedLoginAttempts($request);

            app()->call([$this,'beforeSendingFailedLoginResponseHook']);

            return  $this->failedLoginResponse();

        }

    }

    public function credentials(Request $request)
    {
        return $request->only(['email','password']);
    }

    public function attempt(array $credentials, Request $request, bool $rememberMe)
    {
        return Auth::attempt($credentials, $rememberMe);
    }

    public function rememberMe(Request $request )
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
