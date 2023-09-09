<?php

namespace App\Http\Repositories\Traits;

use App\Http\Requests\Web\Customer\Auth\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
         return 'Registration Failed'; //todo  implement this function
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
