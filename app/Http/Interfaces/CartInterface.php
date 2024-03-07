<?php

namespace App\Http\Interfaces;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

interface CartInterface
{
    public static function handelShoppingCartAfterLogin();

    public function index();

    public function addToCart(Request $request);
    public function increaseQty(Request $request);
    public function decreaseQty(Request $request);
    public function deleteItem(Request $request);




}