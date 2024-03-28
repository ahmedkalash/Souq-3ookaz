<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Cknow\Money\Money;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SetLocalesMidllware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        app()->setLocale($request->segment(1)); // <-- Set the application locale
        Carbon::setLocale($request->segment(1)); // <-- Set the Carbon locale

        URL::defaults(['locale' => $request->segment(1)]); // <-- Set the URL defaults
        // (for named routes we won't have to specify the locale each time!)


        return $next($request);
    }
}
