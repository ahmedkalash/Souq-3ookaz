<?php

namespace App\Http\Traits;

use App\Http\Requests\Web\Customer\Auth\RegisterRequest;
use App\Mail\EmailVerificationMail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

trait RegistersUserTrait
{
    use VerifyEmailTrait;

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
        }catch (\Throwable $e){
            Log::error($e->getMessage(), $e->getTrace());
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










}
