<?php

namespace App\Http\Middleware;

use App\Models\Currency;
use App\Services\ProductPriceService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class SetCurrencyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->get('currency_code')){
            if(Currency::where('code',$request->get('currency_code'))->exists()){
                Session::put('currency_code', $request->get('currency_code'));
            }
        }

        ProductPriceService::loadSessionLocaleCurrency();

        return $next($request);
    }
}
