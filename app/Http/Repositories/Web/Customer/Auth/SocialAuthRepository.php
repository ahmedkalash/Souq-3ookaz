<?php

namespace App\Http\Repositories\Web\Customer\Auth;
use App\Http\Interfaces\Web\Customer\Auth\SocialAuthInterface;
use App\Http\Traits\ThrottleFailedLoginsTrait;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Log;
class SocialAuthRepository implements SocialAuthInterface
{
    use ThrottleFailedLoginsTrait;

    public function redirectToProvider(Request $request, $provider){
        return Socialite::driver($provider)->redirect();
    }


    public function handelProviderCallback(Request $request, $provider){

        if($this->checkIfUserIsTemporaryBlocked($request)){
            return $this->tooManyFailedLoginAttemptsResponse($request);
        }

       if($provider == 'google'){
           return $this->handelGoogleCallback($request);
       }
       else return redirect()->route('customer.ShowLoginPage');
    }


    public function handelGoogleCallback(Request $request){
        try {
            $provider_user = Socialite::driver('google')->user();
        }catch (\Throwable $e){
            Log::error( $e->getMessage(), $e->getTrace());
            return redirect()->route('customer.showLoginPage')->withErrors(['login_failed'=>"Something Went wrong. Please try again."]);
        }

        $app_user = User::where([['provider', 'google'],['provider_id', $provider_user->getId()]] )->first();

        if($app_user){
            Auth::login($app_user);
        }elseif ( $app_user = User::where('email',$provider_user->getEmail())->first()){
            $app_user->provider='google';
            $app_user->provider_id=$provider_user->getId();
            $app_user->save();
            Auth::login($app_user);
        }else{
            $app_user = null;
            try {
                DB::transaction(function () use ($provider_user,   &$app_user){
                    $app_user = User::create([
                        'email'=>$provider_user->getEmail(),
                        'first_name'=>$provider_user->getName(),
                        'email_verified_at'=> $provider_user->user['email_verified'] ? date('Y-m-d Hms'):null,
                        'password'=>'default'. Hash::make(Str::random(40)) ,
                        'avatar'=>$provider_user->getAvatar(),
                        'provider'=>'google',
                        'provider_id'=>$provider_user->getId(),
                    ]);
                    $app_user->assignRole('customer');
                });
            } catch (\Throwable $e){
                return redirect()->route('customer.showLoginPage')->withErrors(['login_failed'=>"Something Went wrong. Please try again."]);
            }


            Auth::login($app_user);

        }

        return redirect(RouteServiceProvider::home());
    }
    public function tooManyFailedLoginAttemptsResponse(Request $request){

        return  redirect()->route('customer.showLoginPage')
            ->withErrors(['too_many_failed_login_attempts'=>'Too many failed login attempts'])
            ->with('lockup_minutes', round($this->availableAfter($request) / 60.0 ,2))
            ->setStatusCode(Response::HTTP_TOO_MANY_REQUESTS);

    }


}
