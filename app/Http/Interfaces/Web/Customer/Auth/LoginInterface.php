<?php

namespace App\Http\Interfaces\Web\Customer\Auth;

use Illuminate\Http\Request;

interface LoginInterface
{

    public function showLoginPage();

    public function authenticate(Request $request);

    public function logout(Request $request);

}
