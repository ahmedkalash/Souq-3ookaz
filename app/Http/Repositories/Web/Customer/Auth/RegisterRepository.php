<?php

namespace App\Http\Repositories\Web\Customer\Auth;
use App\Http\Interfaces\Web\Customer\Auth\RegisterInterface;
use App\Http\Repositories\Traits\RegistersUserTrait;
use App\Http\Requests\Web\Customer\Auth\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterRepository  implements RegisterInterface
{
    use RegistersUserTrait;


}
