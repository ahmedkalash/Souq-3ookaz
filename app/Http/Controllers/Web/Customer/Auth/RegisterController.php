<?php

namespace App\Http\Controllers\Web\Customer\Auth;;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\Customer\Auth\RegisterInterface;
use App\Http\Requests\Web\Customer\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        return $this->registerInterface ->register($request);
    }



    public function reSendEmailVerificationNotification()
    {
        $user=Auth::user();
        return $this->registerInterface ->reSendEmailVerificationNotification($user);
    }



    public function verify(string $verification_code){
        $user = Auth::user();
//        dump($verification_code);
//        dump(Session::get('verification_code'));

        return $this->registerInterface->verify($user, $verification_code);
    }


}
