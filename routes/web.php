<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'as'=>'customer.',
    'middleware'=>  [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' , 'guest']
], function (){
    Route::get('/register',[\App\Http\Controllers\Web\Customer\Auth\RegisterController::class, 'showRegistrationPage'])->name('showRegistrationPage');
    Route::post('/register',[\App\Http\Controllers\Web\Customer\Auth\RegisterController::class, 'register'])->name('register');
    Route::get('/login',[\App\Http\Controllers\Web\Customer\Auth\LoginController::class, 'showLoginPage'])->name('showLoginPage');
    Route::post('/login',[\App\Http\Controllers\Web\Customer\Auth\LoginController::class, 'authenticate'])->name('authenticate');
    Route::get('/auth/{provider}/redirect',[\App\Http\Controllers\Web\Customer\Auth\SocialAuthController::class,'redirectToProvider'])
        ->name('redirectToProvider')->whereIn('provider',\Illuminate\Support\Facades\Config::get('auth.supported_auth_providers'));
    Route::get('/auth/{provider}/callback',[\App\Http\Controllers\Web\Customer\Auth\SocialAuthController::class,'handelProviderCallback'])->name('handelProviderCallback');

});








//Route::prefix('{locale}')
//    ->middleware(\App\Http\Middleware\SetLocalesMidllware::class)
//    ->group(function (){
//
//        Route::get('/test',[\App\Http\Controllers\TestController::class, 'test'])->name('test');
//        Route::get('/', function () {
//            return view('customer.welcome');
//        })->name('index');
//
//        Route::get('/about', function () {
//
//        })->name('about');
//
//    });


Route::group([
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

     Route::get('/', function () {
        return view('customer.welcome');
     })->name('index');

     Route::get('/test/{a}/{b}',[\App\Http\Controllers\TestController::class, 'test'])->name('test');
     Route::post('to')->name('to');

});
