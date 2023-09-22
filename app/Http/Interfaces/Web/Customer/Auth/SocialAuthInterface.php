<?php

namespace App\Http\Interfaces\Web\Customer\Auth;

use Illuminate\Http\Request;

interface SocialAuthInterface
{
    public function redirectToProvider(Request $request, $provider);

    public function handelProviderCallback(Request $request, $provider);

}
