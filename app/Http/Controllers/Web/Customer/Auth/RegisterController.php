<?php

namespace App\Http\Controllers\Web\Customer\Auth;;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\Customer\Auth\RegisterInterface;
use App\Http\Requests\Web\Customer\Auth\RegisterRequest;

class RegisterController extends Controller
{
    public RegisterInterface $registerInterface;

    public function __construct(RegisterInterface $registerInterface)
    {
        $this->registerInterface = $registerInterface;
    }

    public function showRegistrationPage()
    {
        return  $this->registerInterface ->showRegistrationPage();
    }


    public function register(RegisterRequest $request){
         return  $this->registerInterface ->register($request);
    }


}
