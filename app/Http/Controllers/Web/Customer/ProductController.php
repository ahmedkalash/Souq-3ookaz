<?php

namespace App\Http\Controllers\Web\Customer;;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\Customer\ProductInterface;
use App\Http\Requests\Web\Customer\StoreOrUpdateProductReviewRequest;
use App\Models\Product;

class ProductController extends Controller
{
    public ProductInterface $ProductInterface;

    public function __construct(ProductInterface $ProductInterface)
    {
        $this->ProductInterface = $ProductInterface;
    }

    public function view(Product $product)
    {
        return  $this->ProductInterface->view($product) ;
    }

    public function storeOrUpdateReview(Product $product, StoreOrUpdateProductReviewRequest $storeOrUpdateProductReviewRequest)
    {
        return $this->ProductInterface->storeOrUpdateReview($product, $storeOrUpdateProductReviewRequest) ;
    }
}
