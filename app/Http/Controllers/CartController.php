<?php

namespace App\Http\Controllers;;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Customer\AddProductToCartRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Interfaces\CartInterface;
use Illuminate\Http\Response;

class CartController extends Controller
{
    public CartInterface $cartInterface;

    public function __construct(CartInterface $cartInterface)
    {
        $this->cartInterface = $cartInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->cartInterface->index();
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function addToCart(AddProductToCartRequest $request)
    {
        return $this->cartInterface->addToCart($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->cartInterface->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return $this->cartInterface->edit($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        return $this->cartInterface->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->cartInterface->destroy($id);
    }

}
