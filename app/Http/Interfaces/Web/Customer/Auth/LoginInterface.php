<?php

namespace App\Http\Interfaces\Web\Customer\Auth;

use App\Http\Requests\LoginRequest;

interface LoginInterface
{

    public function showLoginPage();


    public function authenticate(LoginRequest $request);

}
