<?php

namespace App\Http\Repositories\Web\Customer;
use App\Http\Interfaces\Web\Customer\ProductInterface;
use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;
class ProductRepository implements ProductInterface
{
    public function view(Product $product) //
    {
        $product->load([
            'reviews' => fn (Builder $query) => $query
                ->with(['user'])
                ->where('publishable', true),

            'related_products' => fn (Builder $query) => $query
                ->with(['categories'=> fn (Builder $query) => $query
                    ->select('product_categories.id','name')])
                ->withAvg
                (
                    ['reviews' => fn($query)=>$query->where('publishable', true)],
                    'rate'
                )
                ->orderBy('id','asc')
                ->limit(10), /** only first {10} products will be shown in the related products section*/

            'attributes',

            'categories'
            ]) ;

        $product->gallery = $product->getMedia('gallery');

        $product->thumbnail = $product->getFirstMedia('thumbnail');

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

        $product->reviews->ratings_percentage = $ratings_percentage;

//        dd($product);

        return view('customer.product.PDP.product-bundle', compact('product'));
    }


}
