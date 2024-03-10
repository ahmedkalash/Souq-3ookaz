<?php

use App\Http\Controllers\CartController;
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
Route::get('/webhook',function (){

});


Route::post('/webhook',function (){

// Set the content type header
    header('Content-Type: application/json');

// Retrieve environment variables
    $webhook_verify_token = '123';
    $graph_api_token = 'EAAdrXZAve800BOZBJk0TAKWI7tlbBRqskdUAsGLeZCw8xvQo2H8JmiKRLVyiqZBCAegQ7frXoUcnZA6VUwVKHPlMx4KgMbAq8T71Kxh5AQBGofrSWAHsCyZBUqwaCGj55HI07CtpsoUFropKaKdJC8caaWp2M0Qe12uZCniqoSoOQOeFPcrIrErxm21syxkSGvW5xZAIfpyuCNKYd3lvYXoZD';


 //Define the webhook route
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the request body
        $request_body = file_get_contents('php://input');
        $body = json_decode($request_body);
        \Illuminate\Support\Facades\Log::info($request_body);
        // Log incoming messages
        error_log("Incoming webhook message: " . json_encode($body, JSON_PRETTY_PRINT));

        // Check if the webhook request contains a message
        $message = $body->entry[0]->changes[0]->value->messages[0] ?? null;

        // Check if the incoming message contains text
        if ($message && $message->type === "text") {
            // Extract the business number to send the reply from it
            $business_phone_number_id = $body->entry[0]->changes[0]->value->metadata->phone_number_id;

            // Send a reply message
            $data = json_encode([
                'messaging_product' => 'whatsapp',
                'to' => $message->from,
                'text' => ['body' => 'Echo: ' . $message->text->body],
                'context' => ['message_id' => $message->id],
            ]);

            $headers = [
                'Authorization: Bearer ' . $graph_api_token,
                'Content-Type: application/json',
            ];

            // Send message
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v18.0/{$business_phone_number_id}/messages");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            // Mark incoming message as read
            $data = json_encode([
                'messaging_product' => 'whatsapp',
                'status' => 'read',
                'message_id' => $message->id,
            ]);

            // Send read status
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v18.0/{$business_phone_number_id}/messages");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
        }

        // Respond with 200 OK
        http_response_code(200);
        exit();
    }
});



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


    // logout
    Route::post('/logout',[\App\Http\Controllers\Web\Customer\Auth\LoginController::class, 'logout'])->name('logout');


    Route::controller(\App\Http\Controllers\Web\Customer\ProductController::class)
        ->group(function (){
            Route::get('/products/{product:id}','view')
                ->name('product.PDP');
            Route::post(
                '/products/{product:id}/reviews', 'storeOrUpdateReview')
                ->name('product.storeReview');
        });

    Route::controller(CartController::class)
        ->group(function (){
            Route::get('/cart', 'index')
                ->name('cart.index');

            Route::post('/cart', 'addToCart')
                ->name('cart.add');

            Route::post('/cart/increase', 'increaseQty')
                ->name('cart.increaseQty');

            Route::post('/cart/decrease', 'decreaseQty')
                ->name('cart.decreaseQty');

            Route::delete('/cart/{product_id}', 'deleteItem')
                ->name('cart.deleteItem');

        });

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
