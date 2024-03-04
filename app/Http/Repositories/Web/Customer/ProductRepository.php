<?php

namespace App\Http\Repositories\Web\Customer;
use App\Http\Interfaces\Web\Customer\ProductInterface;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Http\Requests\Web\Customer\StoreOrUpdateProductReviewRequest;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProductRepository implements ProductInterface
{
    public function view(Product $product)
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

        /*** @var ProductReview|null $current_user_review */
        $current_user_review = $product->reviews->where('user_id', Auth::id())->first();

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

        return view(
            'customer.product.PDP.product-bundle',
            compact(
                'product',
                'current_user_review'
            )
        );
    }

    public function storeOrUpdateReview(Product $product, StoreOrUpdateProductReviewRequest $storeOrUpdateProductReviewRequest)
    {
        $data = $storeOrUpdateProductReviewRequest->validated();
        $product->reviews()
            ->updateOrCreate(
                [
                    'user_id' => $data['user_id'],
                    'product_id' => $data['product_id']
                ],
                array_merge(
                    [
                        'publishable'=> true,
                    ],
                    $data
                )
        );
        Alert::success(__('PDP.alerts.Thank you for your review'))->position();
        return back();
    }



}
