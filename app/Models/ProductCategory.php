<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class ProductCategory extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;
    protected $guarded=[];

    protected $translatable = ['name'];


    public function parent(){
        return $this->belongsTo(ProductCategory::class,'parent_id');
    }



    public function children(){
        return $this->hasMany(ProductCategory::class,'parent_id');
    }



}
