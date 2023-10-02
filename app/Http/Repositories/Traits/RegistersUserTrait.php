<?php

namespace App\Http\Repositories\Traits;

use App\Http\Requests\Web\Customer\Auth\RegisterRequest;
use App\Mail\EmailVerificationMail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

trait RegistersUserTrait
{
    public function showRegistrationPage()
    {
        return view('customer.auth.register');
    }

    public function register(RegisterRequest $request){

        app()->call([$this,'beforeRegistrationTransactionStartHook']);
        try {
            DB::transaction(function () use ($request){

                app()->call([$this,'afterRegistrationTransactionStartHook']);

                $user = $this->create($request);
                $this->assignRoles($user);
                $this->login($user);
                $this->sendEmailVerificationNotification($user);
                app()->call([$this,'beforeRegistrationTransactionEndsHook']);

            });
        }catch (\Throwable){
              return app()->call([$this,'failedRegistrationResponse']);
        }

        app()->call([$this,'afterRegistrationTransactionEndsHook']);


        return app()->call([$this,'successfulRegistrationResponse']);
    }


    public function create(RegisterRequest $request){
        return User::query()->create([
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
        ]);
    }


    public function assignRoles(User $user){
        $user->assignRole('customer');
    }

    public function login(User $user){
        Auth::login($user);
    }

    public function successfulRegistrationResponse(){
        return redirect(RouteServiceProvider::home());
    }
    public function failedRegistrationResponse()
    {
        return redirect()->route('customer.showRegistrationPage')->withErrors(['registration_failed'=>  ('Registration failed please try again') ]);
    }

    public function beforeRegistrationTransactionStartHook()
    {
        //
    }

    public function afterRegistrationTransactionStartHook()
    {
        //
    }

    public function beforeRegistrationTransactionEndsHook()
    {
        //
    }

    public function afterRegistrationTransactionEndsHook()
    {
        //
    }



    public function sendEmailVerificationNotification(User $user)
    {
        Session::forget('verification_code');
        $verification_code = Str::random(10);
        Session::put('verification_code',[
            'code'=>$verification_code,
            'exp'=> Carbon::now()->addMinutes(15)
        ]);
        Mail::to($user->email)->send(new EmailVerificationMail($user, $verification_code));
    }

    public function reSendEmailVerificationNotification(User $user)
    {
        $this->sendEmailVerificationNotification($user);
        return 'An email was sent to your email. Check your email.';
    }



    public function verify(User $user, string $verification_code){
        $stored_verification_code = Session::get('verification_code');
        if( isset($stored_verification_code) && ($stored_verification_code['code'] == $verification_code) && ($stored_verification_code['exp'] > now()) ){
            Session::forget('verification_code');
            $user->email_verified_at = now();
            $user->save();
            return redirect(RouteServiceProvider::home());
        }else{
            return  ('Invalid code please try again');
        }

    }






}
