<?php

namespace App\Http\Interfaces\Web\Customer;

use App\Models\Product;

interface ProductInterface
{
    public function view(Product $product);
}