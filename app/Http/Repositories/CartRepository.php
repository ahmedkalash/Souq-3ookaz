<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\CartInterface;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
     * */

    const SESSION_CART_KEY = 'user_cart_products_ids';

    public function index()
    {
        if (Auth::check()) {
            $cart = CartItem::where('user_id', Auth::id())
                ->with('product')
                ->get();

            return view('customer.cart.index', compact('cart'));
        } else {
            $session_cart_product_qty = Session::get(static::SESSION_CART_KEY, []);

            $cart = Product::whereIn('id', array_keys($session_cart_product_qty))
                ->get();

            return view('customer.cart.index', compact('cart', 'session_cart_product_qty'));
        }
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
            $cart = Session::get(static::SESSION_CART_KEY, []);
            if (isset($cart[$request->get('product_id')])) {
                $cart[$request->get('product_id')] += $request->qty;
            } else {
                $cart[$request->get('product_id')] = $request->qty;
            }
            Session::put(static::SESSION_CART_KEY, $cart);
        }

//        Alert::success(__('alerts.product_add_to_cart_successfully'));
        return [];
    }

    public function increaseQty(Request $request)
    {
        $data = $request->validated();

        if(Auth::check()){
            /** DB cart */
            CartItem::query()
                ->updateOrCreate(
                    [
                        'product_id' => $data['product_id'],
                        'user_id' => Auth::id(),
                    ],
                    [
                        'qty' => DB::Raw("cart_items.qty + {$data['qty']}"),
                    ]
                );

        }else{
            /** session cart */
            $cart = Session::get(static::SESSION_CART_KEY, []);
            if (isset($cart[$data['product_id']])) {
                $cart[$data['product_id']] += $data['qty'];
            } else {
                $cart[$data['product_id']] = $data['qty'];
            }
            Session::put(static::SESSION_CART_KEY, $cart);
        }

        return [];
    }

    public function decreaseQty(Request $request){
        $data = $request->validated();

        if(Auth::check()){
            /** DB cart */
            $cart_item = CartItem::query()->where('product_id', $data['product_id'])
                ->where('user_id' , Auth::id())->first();

            if($cart_item && ($cart_item->qty - $data['qty'] > 0)){
                $cart_item->qty -= $data['qty'];
                $cart_item->save();
            }else{
                $cart_item?->delete();
            }

        }else{
            /** session cart */
            $cart = Session::get(static::SESSION_CART_KEY, []);
            if (isset($cart[$data['product_id']]) && ($cart[$data['product_id']] - $data['qty']) > 0 ) {
                $cart[$data['product_id']] -= $data['qty'];
            } else {
                unset($cart[$data['product_id']]);
            }
            Session::put(static::SESSION_CART_KEY, $cart);
        }

        return [];
    }

    public function deleteItem(Request $request)
    {
        return [
            'deleteItem'
        ];
    }



    public static function handelShoppingCartAfterLogin()
    {
        $session_cart = Session::get(static::SESSION_CART_KEY, []);

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

        Session::remove(static::SESSION_CART_KEY);
    }



}