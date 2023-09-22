<?php

namespace App\Http\Controllers\Web\Customer\Auth;;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\Customer\Auth\SocialAuthInterface;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    public $socialAuthInterface;

    public function __construct(SocialAuthInterface $socialAuthInterface)
    {
        $this->socialAuthInterface = $socialAuthInterface;
    }


    public function redirectToProvider(Request $request, $provider){
        return $this->socialAuthInterface->redirectToProvider($request, $provider);
    }


    public function handelProviderCallback(Request $request, $provider){
        return $this->socialAuthInterface->handelProviderCallback($request, $provider);
    }


}
