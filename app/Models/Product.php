<?php

namespace App\Models;

use App\Http\Repositories\Web\Customer\ProductRepository;
use App\Models\Traits\CanGetTableInfoStatically;
use Carbon\Carbon;
use Cknow\Money\Casts\MoneyDecimalCast;
use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia, CanGetTableInfoStatically;

    protected $appends = [];

    protected $guarded=[];

    protected $translatable = ['name', 'description', 'brand', 'short_description'];

    protected $casts = [
        'price' => MoneyIntegerCast::class,
        'when_special_price_start' => 'datetime',
        'when_special_price_end' => 'datetime',
    ];

    public const RELATED_PRODUCTS_LIMIT = 10;

    /***
     * Special price may be
     *      - fixed price
     *      - percentage of the original price
     */
    public function specialPriceValue()
    {
        if(!$this->isSpecialPriceValid()){
            return null;
        }

        if($this->special_price_type == 'fixed'){
            return localize_money(money("$this->special_price", config('app.default_currency')));
        }else{
            // now special_price_type == 'percentage'
            $percentage = bcdiv("$this->special_price", '100',14);
            return $this->price->multiply($percentage);
        }
    }

    public function specialPricePercentage():?string
    {
        if(!$this->isSpecialPriceValid()){
            return null;
        }

        if($this->special_price_type == 'fixed'){
            if(!$this->price->isZero()) {
                $special_price = money("$this->special_price", config('app.default_currency'));
                return bcmul($special_price->ratioOf($this->getOriginal('price')), '100',2);
            }
            return 0;
        }else{
            // now special_price_type == 'percentage'
            return $this->special_price;
        }
    }

    public function discountPercentage():string
    {
        if(!$this->isSpecialPriceValid()){
            return 0;
        }

        return bcsub('100' , $this->specialPricePercentage());
    }

    public function isSpecialPriceValid()
    {
        if(!$this->has_special_price){
            return false;
        }

        if(
            Carbon::now()->lt($this->when_special_price_start) ||
            Carbon::now()->gt($this->when_special_price_end)
        ){
            return false;
        }

        return true;
    }

    public function gallery(){
        return $this->morphMany(Media::class, 'model')
            ->where('collection_name', 'gallery');
    }

    public function thumbnail(){
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'thumbnail');
    }

    public function attributes(){
        return $this->hasMany(ProductAttribute::class);
    }

    public function reviews(){
        return $this->hasMany(ProductReview::class);
    }

    public function categories(){
        return $this->belongsToMany(
            ProductCategory::class,
            'category_has_products',
            'product_id',
            'product_category_id',
            )
            ->withTimestamps();
    }

    public function related_products()
    {
        return $this->belongsToMany(
            static::class,
            'product_related_products',
            'product_id',
            'related_product_id',
        );
    }

    public function related_to_products()
    {
        return $this->belongsToMany(
            static::class,
            'product_related_products',
            'related_product_id',
            'product_id',
        );
    }

    public function cartItem()
    {
        return $this->hasMany(CartItem::class)
            ->where('user_id', \Auth::id());
    }

    public function resolveRouteBindingQuery($query, $value, $field = null){
        return parent::resolveRouteBindingQuery($query, $value, $field)
            ->withAvg([
                'reviews' =>
                    fn($query)=>$query
                    ->where('publishable', true)
                ],
                'rate'
            );
    }

//    public static function query()
//    {
//        $locale_currency_code = session('currency_code');
////        dd($locale_currency_code);
//        return parent::query()
//            ->select()
//            ->selectSub(fn(Builder $query) => $query
//                ->selectRaw('products.price * currencies.exchange_rate_from_base')
//                ->from('currencies')
//                ->where('code','=', $locale_currency_code),
//                "localised_price"
//            )
//            ->selectRaw("'$locale_currency_code' as locale_currency_code");
//
//    }
}
