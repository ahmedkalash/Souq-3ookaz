<?php

namespace App\Http\Repositories\Web\Customer\Auth;
use App\Http\Interfaces\Web\Customer\Auth\RegisterInterface;
use App\Http\Traits\RegistersUserTrait;

class RegisterRepository  implements RegisterInterface
{
    use RegistersUserTrait;


}
