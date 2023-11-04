<?php

namespace App\Http\Controllers\Web\Customer\Auth;;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\Customer\Auth\ResetPasswordInterface;
use App\Http\Requests\Web\Customer\Auth\PasswordResetRequest;
use App\Http\Requests\Web\Customer\Auth\SendPasswordResetEmailRequest;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\UnauthorizedException;
use function Symfony\Component\String\b;

class RestPasswordController extends Controller
{
    public $resetPasswordInterface;

    public function __construct(ResetPasswordInterface $resetPasswordInterface)
    {
        $this->resetPasswordInterface = $resetPasswordInterface;
    }

    public function showForgetPasswordPage(Request $request){
        return $this->resetPasswordInterface->showForgetPasswordPage($request);
    }

    public function sendPasswordResetNotification(SendPasswordResetEmailRequest $request){
        return $this->resetPasswordInterface->sendPasswordResetNotification($request);

    }

    public function verifyPasswordResetCode(Request $request, string $password_reset_code){
        return $this->resetPasswordInterface->verifyPasswordResetCode($request, $password_reset_code);
    }

    public function showPasswordResetPage(){
        return $this->resetPasswordInterface->showPasswordResetPage();

    }

    public function passwordReset(PasswordResetRequest $request){
        return $this->resetPasswordInterface->passwordReset($request);
    }













}
