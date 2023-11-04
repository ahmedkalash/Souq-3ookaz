<?php

namespace App\Http\Interfaces\Web\Customer\Auth;

use Illuminate\Http\Request;

interface ResetPasswordInterface
{
    public function showForgetPasswordPage(Request $request);

    public function sendPasswordResetNotification(Request $request);

    public function verifyPasswordResetCode(Request $request,string $password_reset_code);

    public function showPasswordResetPage();

    public function passwordReset(Request $request);
}
