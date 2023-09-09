<?php

namespace App\Http\Repositories\Web\Customer\Auth;
use App\Http\Interfaces\Web\Customer\Auth\LoginInterface;
use App\Http\Repositories\Traits\AuthenticateUserTrait;

class LoginRepository  implements LoginInterface
{
    use AuthenticateUserTrait;
}

