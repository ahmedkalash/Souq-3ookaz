<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\CartInterface;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class CartRepository  implements CartInterface
{
    /*** Some notes about how the cart works ***
     *
     * If the user is logged in, then the cart is stored in the DB.
     * Else If the user is not logged in, then the cart is stored in the session.
     * When the user logs in, the session cart will be moved form session to
     *      the DB by (adding new cart items or updating the {qty} of an existing one).
     * When the user log add/update a product to the cart (session or DB cart) it is validated against the stock of the product
     *      except when moving the session cart to the DB so after updating the DB cart with the session cart there may be some
     *      cart items qty that may exceed the stock of the product. The reason I left if is I was not sure how the error msg will go as a UX.
     * */



    public function index()
    {
        //toDo
    }

    public function addToCart(Request $request)
    {
        if(Auth::check()){
            /** DB cart */
            $cart_item = CartItem::where('product_id', $request->get('product_id'))
                ->where('user_id', Auth::id())->first();
            if ($cart_item){
                $cart_item->qty++;
                $cart_item->save();
            }else{
                CartItem::create([
                    'user_id'=>Auth::id(),
                    'product_id' => $request->get('product_id'),
                    'qty' => $request->get('qty'),
                ]);
            }
        }else{
            /** session cart */
            $cart = Session::get('user_cart_products_ids', []);
            if (isset($cart[$request->get('product_id')])) {
                $cart[$request->get('product_id')] += $request->qty;
            } else {
                $cart[$request->get('product_id')] = $request->qty;
            }
            Session::put('user_cart_products_ids', $cart);
        }

        Alert::success(__('alerts.product_add_to_cart_successfully'));
        return back();
    }

    public static function handelShoppingCartAfterLogin()
    {
        $session_cart = Session::get('user_cart_products_ids', []);

        $session_products_id = array_keys($session_cart);

        $db_cart = CartItem::query()
            ->where('user_id', Auth::id())
            ->whereIn('product_id', $session_products_id)
            ->get();

        $db_cart_ids = $db_cart->pluck('product_id')->toArray();

        $rows = [];
        foreach ($session_cart as $product_id => $qty){
            if(in_array($product_id, $db_cart_ids)){
                continue;
            }

            $rows[] = [
                'user_id' => Auth::id(),
                'product_id' => $product_id,
                'qty' => $qty,
            ];
        }

        CartItem::query()->insert($rows);

        foreach ($db_cart as $cart_item){
            $cart_item->qty += $session_cart[$cart_item->product_id];
            $cart_item->save();
        }

        Session::remove('user_cart_products_ids');
    }

    public function create()
    {
        //toDo
    }



    /**
     * @param $id
     */
    public function show($id)
    {

    }

    /**
     * @param $id
     */
    public function edit($id)
    {

    }

    /**
     * @param $request
     * @param $id
     */
    public function update($request, $id)
    {

    }

    /**
     * @param $id
     */
    public function destroy($id)
    {

    }


}