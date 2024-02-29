<?php

namespace App\Http\Interfaces\Web\Customer;

use App\Http\Requests\Web\Customer\StoreOrUpdateProductReviewRequest;
use App\Models\Product;

interface ProductInterface
{
    public function view(Product $product);
    public function storeOrUpdateReview(Product $product, StoreOrUpdateProductReviewRequest $storeOrUpdateProductReviewRequest);
}