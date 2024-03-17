<?php

namespace App\Http\Controllers;

use App;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Web\Customer\Auth\RegisterRepository;
use App\Mail\EmailVerificationMail;
use App\Models\CartItem;
use App\Models\ProductCategory;
use App\Models\User;
use Brick\Math\BigDecimal;
use CurrencyApi\CurrencyApi\CurrencyApiClient;
use Decimal\Decimal;
use Illuminate\Cache\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Interfaces\TestInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\LaravelSettings\Settings;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class a
{
    public function __construct()
    {
        dd(\session('currency_code'));
    }
}

class TestController extends Controller
{
    public $testInterface;

    public function __construct(TestInterface $testInterface , public RateLimiter $rateLimiter)
    {

//        dd('TestController __construct');
//        dd(\session('currency_code'));
        $this->testInterface = $testInterface;
    }

    public function test( Request $request)
    {
        $currencyApi = new CurrencyApiClient(env('CURRENCY_API_KEY'));


        $decimal = '0.2';
//        $decimal = 0.2;
        dump ((1.40 * 165 - 230.0));
        dump (bcsub(bcmul('1.40','165',50), '230.0', 50));
        dump (bcmul(bcdiv('1','3', 50), 3,50));

        dump ($decimal * 1000000000);
        dump (623400000.0 - 623399985.58574);

        dump ('<br>');
        dump ( (0.2  + 0.2 + 0.2  + 0.2 +   0.2));



        $i=0.0;
        $num='0.0';
        for ( ; $i < 1000000000; $i++){
            $num = bcadd($num, $decimal,0);
//            $num += $decimal;

        }
        echo $num . '<br>';

//        echo 200000000 - 199999997.49084;

//         19999999.962259
        // 20000000.00000000000000000000
 //  200000000 - 199999997.49084 = 2.5091600120068

//




        //        DB::transaction(function (){
    //            User::create([
    //                'first_name'=>'sghdfgh',
    //                'email'=>'Hkyseduma@mailinator.com123',
    //
    //            ]);
    //        });

    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->testInterface->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->testInterface->create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $products = App\Models\Product::  get();

        foreach ($products as $product){
            /*** @var App\Models\Product $product */
            $product->addMedia($request->file('image'))
                ->preservingOriginal()
            ->toMediaCollection('default', 'public');
        }

        return;


        /**** @var  User $user*/
        $user  = User::first();
        $media_collection = $user->getMedia('images')->find(5);




//        dump($media_collection->original_url);
//        dump($media_collection->getUrl());
//
//        dd($media_collection);

//        $path = $request->file('image')->storeAS('', 'avswew');
//        $user->addMedia($request->file('image'))->toMediaCollection('images') ;
//        $product =  App\Models\product::create([
//            'name'=>'abc'
//        ]);
        $product = App\Models\Product::first();
         $user->addMedia($request->file('image'))
             ->usingName('image_1234567498')
             ->usingFileName('image_name_123456749.asdas')
             ->withCustomProperties([
                 'image_title'=>'asdadsf',
                 'image_alt'=>'qweqw'
             ])
             ->toMediaCollection('images')

         ;


//        $path = $request->file('image')   ->store('public/asd');
//        $path = $request->file('image')->storePublicly('asd');


        //return $this->testInterface->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->testInterface->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->testInterface->edit($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->testInterface->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->testInterface->destroy($id);
    }

}
