<?php

namespace App\Models;

use App\Models\Traits\CanGetTableInfoStatically;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class ProductCategory extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia, HasRecursiveRelationships, CanGetTableInfoStatically;


    /**
     * @var array|mixed|string[]
     */

    protected $guarded=[];

    protected $translatable = ['name'];

    protected $casts = [
        'name'=>'array'
        ];





    public function parent(){
        return $this->belongsTo(ProductCategory::class,'parent_id');
    }

    public function recursiveParent(){
        return $this->belongsTo(ProductCategory::class,'parent_id')->with('recursiveParent');
    }



    public function children(){
        return $this->hasMany(ProductCategory::class,'parent_id');
    }



    public function products(){
        return $this->belongsToMany(
            Product::class,
            'category_has_products',
            'product_category_id',
            'product_id',
        )->withTimestamps();
    }










}
