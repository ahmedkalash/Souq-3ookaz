<?php

namespace App\Http\Repositories\Web\Customer;
use App\Http\Interfaces\Web\Customer\ProductInterface;
use App\Models\Product;

class ProductRepository implements ProductInterface
{
    public function view(Product $product)
    {
        $product->load(['reviews'=>['user'], 'attributes']) ;



        $product->gallery = $product->getMedia('gallery');

        $ratings_percentage = [];

        foreach ($product->reviews as $review){
            if(!isset($ratings_percentage[$review->rate])){
                $ratings_percentage[$review->rate] = 1;
            }else{
                $ratings_percentage[$review->rate]++;
            }
        }
        foreach ($ratings_percentage as &$count){
            $count = round(($count/$product->reviews->count()) * 100);
        }

        $average_rating = round($product->reviews->sum('rate') / ( $product->reviews->count()) );

        $product->reviews->ratings_percentage = $ratings_percentage;
        $product->reviews->average_rating = $average_rating;


        return view('customer.product.PDP.product-bundle', compact('product'));
    }


}
