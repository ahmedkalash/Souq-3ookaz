<?php

namespace App\Http\Controllers\Web\Customer\Auth;;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\Customer\Auth\LoginInterface;
use App\Http\Requests\Web\Customer\Auth\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public LoginInterface $loginInterface;

    public function __construct(LoginInterface $loginInterface)
    {
        $this->loginInterface = $loginInterface;
    }


    public function showLoginPage(){
        return  $this->loginInterface ->showLoginPage();
    }


    public function authenticate(LoginRequest $request){
        return  $this->loginInterface ->authenticate($request);
    }

    public function logout(Request $request)
    {
        return $this->loginInterface->logout($request);


    }


}
