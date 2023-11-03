<?php

namespace App\Http\Controllers;

use App;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Web\Customer\Auth\RegisterRepository;
use App\Mail\EmailVerificationMail;
use App\Models\User;
use Illuminate\Cache\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Http\Request;
use App\Http\Interfaces\TestInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class TestController extends Controller
{
    public $testInterface;


    public function __construct(TestInterface $testInterface , public RateLimiter $rateLimiter)
    {
        $this->testInterface = $testInterface;
    }

    public function test( )
    {

        $this->rateLimiter->for('test', function (){
            return Limit::perMinutes(1,2)->by(1);
        });
        dump($this->rateLimiter->hit(1,60));
        dump($this->rateLimiter->availableIn(1));
        dump($this->    rateLimiter);



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
        return $this->testInterface->store($request);
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
