<?php

use App\Http\Controllers\Web\Customer\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
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





// redirecting the default laravel routes to custom routes
Route::get('/redirect-to-login',function (){
    return redirect()->route('customer.showLoginPage');
})->name('login');

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'as'=>'customer.',
    'middleware'=>  [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function (){

    Route::group([
        'middleware' => [ 'guest']
    ], function(){


        // auth
        Route::get('/register',[\App\Http\Controllers\Web\Customer\Auth\RegisterController::class, 'showRegistrationPage'])->name('showRegistrationPage');
        Route::post('/register',[\App\Http\Controllers\Web\Customer\Auth\RegisterController::class, 'register'])->name('register');
        Route::get('/login',[\App\Http\Controllers\Web\Customer\Auth\LoginController::class, 'showLoginPage'])->name('showLoginPage');
        Route::post('/login',[\App\Http\Controllers\Web\Customer\Auth\LoginController::class, 'authenticate'])->name('authenticate');
        Route::get('/auth/{provider}/redirect',[\App\Http\Controllers\Web\Customer\Auth\SocialAuthController::class,'redirectToProvider'])
            ->name('redirectToProvider')->whereIn('provider',\Illuminate\Support\Facades\Config::get('auth.supported_auth_providers'));
        Route::get('/auth/{provider}/callback',[\App\Http\Controllers\Web\Customer\Auth\SocialAuthController::class,'handelProviderCallback'])->name('handelProviderCallback');

        // password rest
        Route::get('/forget-password',[ResetPasswordController::class,'showForgetPasswordPage'])->name('showForgetPasswordPage');
        Route::post('/send-password-reset-email',[ResetPasswordController::class,'sendPasswordResetNotification'])
            ->name('sendPasswordResetEmail')->middleware(['throttle:5,1']);
        Route::get('/verify-password-reset-code/{password_reset_code}',[ResetPasswordController::class,'verifyPasswordResetCode'])
            ->name('verifyPasswordResetCode')->middleware(['throttle:5,1']);
        Route::get('/password-reset',[ResetPasswordController::class,'showPasswordResetPage'])->name('showPasswordResetPage');
        Route::post('/password-reset',[ResetPasswordController::class,'passwordReset'])
            ->name('passwordReset')->middleware(['throttle:5,1']);


    });

    Route::group([
        'middleware' => ['auth']
    ], function(){

        // email verify
         Route::get('/email-verify/resend-verification-code',[\App\Http\Controllers\Web\Customer\Auth\RegisterController::class, 'reSendEmailVerificationNotification'])
             ->name('reSendEmailVerificationNotification')->middleware(['throttle:1,1']);
         Route::get('/email-verify/{verification_code}',[\App\Http\Controllers\Web\Customer\Auth\RegisterController::class, 'verify'])
             ->name('verify')->middleware(['throttle:3,1']);

    });




    Route::post('/logout',[\App\Http\Controllers\Web\Customer\Auth\LoginController::class, 'logout'])->name('logout');





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
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function(){

     Route::get('/', function () {
        return view('customer.welcome');
     })->name('index');

     Route::get('/test',[\App\Http\Controllers\TestController::class, 'test'])->name('test');
     Route::post('/test',[\App\Http\Controllers\TestController::class, 'store'])->name('test.store');


});



