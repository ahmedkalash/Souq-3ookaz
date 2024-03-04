<?php

namespace App\Http\Interfaces;

use App\Models\Product;
use Illuminate\Http\Request;

interface CartInterface
{

    public static function handelShoppingCartAfterLogin();

    public function index();

    public function addToCart(Request $request);

    /**
     * @param $id
     */
    public function show($id);

    /**
     * @param $id
     */
    public function edit($id);

    /**
     * @param $request
     * @param $id
     */
    public function update($request, $id);

    /**
     * @param $id
     */
    public function destroy($id);


}