<?php

namespace App\Http\Controllers;

use App;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Web\Customer\Auth\RegisterRepository;
use App\Mail\EmailVerificationMail;
use App\Models\CartItem;
use App\Models\ProductCategory;
use App\Models\User;
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

class TestController extends Controller
{
    public $testInterface;

    public function __construct(TestInterface $testInterface , public RateLimiter $rateLimiter)
    {
        $this->testInterface = $testInterface;
    }

    public function test( Request $request )
    {

        $res = CartItem::query()
            ->updateOrCreate(
                [
                    'product_id' => 1,
                    'user_id' =>  3,
                ],
                [
                    'qty' => DB::Raw("cart_items.qty + 5") ,
                ]
            )->toRawSql();

        dd($res);



        /*** @var Collection $cat*/
      $cat = ProductCategory::tree(50);

        $constraint = function ($query) {
            $query->whereNotIn('id', [1,3,4]);
        };

        $tree = ProductCategory::treeOf($constraint)->get()->totree();



      dd($tree);



      $cat = App\Models\ProductCategory::find(80);

       $cat->update([
                'parent_id'=>84
            ]);


        try {
            $cat->update([
                'parent_id'=>84
            ]);
        }catch (\Throwable $e){
            dump($e);
        }



        return view('customer.test');




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
