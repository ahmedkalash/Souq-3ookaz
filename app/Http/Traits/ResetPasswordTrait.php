<?php

namespace App\Http\Traits;

use App\Mail\PasswordResetMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

trait ResetPasswordTrait
{
    public function showForgetPasswordPage(Request $request){
        return view('customer.auth.forget-password');
    }

    public function sendPasswordResetNotification(Request $request){
        $token = $this->generatePasswordResetToken();
        $email = $request->email;
        $ttl = $this->passwordResetTokenExpirationTime();

        // The user must confirm again that he/she has access to the email they claim to have access to it.
        session()->forget('can_reset_password');
        // forget old password_ reset code
        session()->forget('password_reset_code');

        session()->put([
            'password_reset_code'=>[
                'code'=> $token,
                'email'=> $email,
                'ttl'=> $ttl,
            ]
        ]);

        $user = $this->user($email);

        $this->sendPasswordResetMail($user, $email, $token);

        return $this->passwordResetNotificationResponse();
    }

    public function generatePasswordResetToken():string
    {
        return Str::random();
    }

    public function passwordResetTokenExpirationTime():string
    {
        return now()->addMinutes(10)->toDateTimeString();
    }

    public function sendPasswordResetMail(User $user, string $email, string $token):void
    {
        Mail::to($email)
            ->send(new PasswordResetMail($user, $token));
    }

    public function passwordResetNotificationResponse()
    {
        Alert::toast('An email was sent to you email', 'info');
        return back();
    }

    public function user(string $email)
    {
        return User::where('email', $email)->first();
    }




    public function verifyPasswordResetCode(Request $request,string $password_reset_code){

        if($this->validatePasswordResetToken($password_reset_code))
        {
            $email = session('password_reset_code')['email'];

            $ttl = $this->passwordResetPermeationExpirationTime();

            session()->forget('password_reset_code');

            session()->forget('can_reset_password');

            session()->put('can_reset_password',[
                'email'=> $email,
                'ttl'=> $ttl,
            ]);

            return $this->successfulPasswordResetCodeVerificationResponse();

        }else{

            return $this->failedPasswordResetCodeVerificationResponse();
        }

    }

    public function validatePasswordResetToken(string $password_reset_code):bool
    {
        return (
            session('password_reset_code') &&
            (session('password_reset_code')['code'] == $password_reset_code) &&
            Carbon::parse(session('password_reset_code')['ttl'])->greaterThan(now())
        );
    }

    public function passwordResetPermeationExpirationTime():string
    {
        return now()->addMinutes(5)->toDateTimeString();
    }

    public function successfulPasswordResetCodeVerificationResponse()
    {
        return redirect()->route($this->routesNamesPrefix().'.showPasswordResetPage');
    }

    public function failedPasswordResetCodeVerificationResponse()
    {
        Alert::toast('Invalid password reset code!', 'error');
        return redirect()->route($this->routesNamesPrefix().'.showLoginPage');
    }



    public function showPasswordResetPage(){
        if( ! $this->validatePasswordResetPermeation() ){
            return $this->invalidPasswordResetPermeationResponse();
        }

        return view('customer.auth.password-reset');

    }

    public function passwordReset(Request $request){
        if( ! $this->validatePasswordResetPermeation() ){
            return $this->invalidPasswordResetPermeationResponse();
        }

        $email = session('can_reset_password')['email'];

        $user = $this->user($email);

        session()->forget('can_reset_password');

        $this->changePassword($user, $request->password);

        return $this->successfulPasswordResetAttemptResponse();

    }

    public function validatePasswordResetPermeation(): bool
    {
        return (
            session('can_reset_password') &&
            Carbon::parse(session('can_reset_password')['ttl'])->greaterThan(now())
        );
    }

    public function invalidPasswordResetPermeationResponse()
    {
        Alert::toast('Your are not allowed to do this action', 'error');
        return redirect()->route($this->routesNamesPrefix().'.showLoginPage');
    }

    public function changePassword(User $user, string $newPassword): void
    {
        $user->password = Hash::make($newPassword);
        $user->save();
    }

    public function successfulPasswordResetAttemptResponse()
    {
        Alert::toast('Password was changed successfully', 'success');

        return redirect()->route($this->routesNamesPrefix().'.showLoginPage');
    }


    public function routesNamesPrefix(): string
    {
        return 'customer';
    }
}
