<?php

namespace App\Http\Interfaces\Web\Customer\Auth;

use App\Http\Requests\Web\Customer\Auth\RegisterRequest;
use App\Models\User;

interface RegisterInterface
{
    public function showRegistrationPage();

    public function register(RegisterRequest $request);

    public function reSendEmailVerificationNotification(User $user);

    public function verify(User $user, string $verification_code);

}

