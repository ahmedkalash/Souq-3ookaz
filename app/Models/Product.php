<?php

namespace App\Models;

use App\Models\Traits\CanGetTableInfoStatically;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia, CanGetTableInfoStatically;

    protected $appends = [];

    protected $guarded=[];

    protected $translatable = ['name', 'description', 'brand', 'short_description'];

    public const RELATED_PRODUCTS_LIMIT = 10 ;

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

}
