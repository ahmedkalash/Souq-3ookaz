<?php

namespace App\Http\Traits;

use App\Mail\EmailVerificationMail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

trait VerifyEmailTrait
{
    public function sendEmailVerificationNotification(User $user)
    {
        Session::forget('verification_code');
        $verification_code = $this->generateVerificationCode();
         Session::put('verification_code',[
            'code'=>$verification_code,
            'exp'=> $this->verificationCodeExpirationTime(),
         ]);

        Alert::toast('An email was sent to your email. Check your email to verify your email.', 'info');
        Mail::to($user->email)->send(new EmailVerificationMail($user, $verification_code));
    }

    public function reSendEmailVerificationNotification(User $user)
    {
        $this->sendEmailVerificationNotification($user);
        return back();
    }


    public function verify(User $user, string $verification_code){
        $stored_verification_code = Session::get('verification_code');
        if( isset($stored_verification_code)
            && ($stored_verification_code['code'] == $verification_code)
            && ($stored_verification_code['exp'] > now())
        ){
            Session::forget('verification_code');
            $user->email_verified_at = now();
            $user->save();
            Alert::toast('Your email has been verified successfully', 'info');
            return redirect(RouteServiceProvider::home());
        }else{
            Alert::toast('Invalid verification code please try again', 'error');
            return redirect()->route('customer.showLoginPage');
        }

    }

    public function generateVerificationCode():string
    {
        return Str::random(10);
    }

    public function verificationCodeExpirationTime()
    {
        return Carbon::now()->addMinutes(15);
    }


}
