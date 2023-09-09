<?php

namespace App\Http\Interfaces\Web\Customer\Auth;

use App\Http\Requests\Web\Customer\Auth\RegisterRequest;

interface RegisterInterface
{
    public function showRegistrationPage();


    public function register(RegisterRequest $request);
}
