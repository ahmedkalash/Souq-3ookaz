<?php

namespace App\Http\Repositories\Web\Customer\Auth;
use App\Http\Interfaces\Web\Customer\Auth\ResetPasswordInterface;
use App\Http\Requests\Web\Customer\Auth\PasswordResetRequest;
use App\Http\Requests\Web\Customer\Auth\SendPasswordResetEmailRequest;
use App\Http\Traits\ResetPasswordTrait;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Unlimited\Repository\Services\BaseEloquentService;

class ResetPasswordRepository implements ResetPasswordInterface
{
    use ResetPasswordTrait;


}
