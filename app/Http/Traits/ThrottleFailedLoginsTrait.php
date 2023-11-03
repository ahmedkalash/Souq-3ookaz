<?php

namespace App\Http\Traits;

use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait ThrottleFailedLoginsTrait
{
    public function checkIfUserIsTemporaryBlocked(Request $request){
        $key = $this->resolveRequestSignature($request);
        return $this->rateLimiter($request)->tooManyAttempts($key, $this->maxAllowedFailedLoginAttempts($request));
    }

    public function incrementFailedLoginAttempts(Request $request){
        $key = $this->resolveRequestSignature($request);
        $decayMinutes = $this->decayMinutes($request);
        $this->rateLimiter($request)->hit($key, $decayMinutes * 60);
    }

    public function tooManyFailedLoginAttemptsResponse(Request $request){

        return  redirect()->back()
            ->withErrors(['too_many_failed_login_attempts'=>'Too many failed login attempts'])
            ->with('lockup_minutes', round($this->availableAfter($request) / 60.0 ,2))
            ->setStatusCode(Response::HTTP_TOO_MANY_REQUESTS);

    }

    public function clearFailedLoginAttemptsTraking(Request $request){
        $key = $this->resolveRequestSignature($request);
        $this->rateLimiter($request)->clear($key);
    }

    public function rateLimiter(Request $request){
        return property_exists($this, 'rateLimiter')? $this->rateLimiter: app(RateLimiter::class);
    }


    public function maxAllowedFailedLoginAttempts(Request $request){
        return 3;
    }

    public function decayMinutes(Request $request){
        return 1;
    }

    public function availableAfter(Request $request){
        $key = $this->resolveRequestSignature($request);
        return $this->rateLimiter($request)->availableIn($key);
    }


    public function resolveRequestSignature(Request $request){
        return sha1($request->ip());
    }

}
