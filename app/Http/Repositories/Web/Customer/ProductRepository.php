<?php

namespace App\Http\Repositories\Web\Customer;
use App\Http\Interfaces\Web\Customer\ProductInterface;
use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductReview;
use App\Services\ProductPriceService;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Http\Requests\Web\Customer\StoreOrUpdateProductReviewRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;


class ProductRepository implements ProductInterface
{
    protected ProductPriceService $productPriceService;
    public const CURRENCY_CODE_QUERY_STRING = 'currency_code';

    public function __construct()
    {
//        $this->productPriceService = app(ProductPriceService::class, [
//                'currencyModel' => Currency::class,
//                'eagerLoadCurrencies' => [ProductPriceService::localeCurrencyCode()]
//        ]);
//        $this->productPriceService->loadSessionLocaleCurrency();
    }

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
                ->limit(10), /** only the first {10} products will be shown in the related products section*/

            'attributes',

            'categories',

            'gallery',

            'thumbnail',
        ]);

        /*** @var ProductReview|null $current_user_review */
        $current_user_review = $product->reviews->where('user_id', Auth::id())->first();

        $product->reviews->ratings_percentage = $this->calculateRatingsPercentage($product);
         (ProductPriceService::getLocaleCurrency());

        return view(
            'customer.product.PDP.product-bundle',
            compact(
                'product',
                'current_user_review',
            ),
//            ['productPriceService'=> $this->productPriceService]
        );
    }

    public function calculateRatingsPercentage($product)
    {
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
        return $ratings_percentage;
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
