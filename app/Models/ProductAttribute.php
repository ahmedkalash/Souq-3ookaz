<?php

namespace App\Models;

use App\Models\Traits\CanGetTableInfoStatically;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class ProductAttribute extends Model
{
    use HasFactory, HasTranslations, CanGetTableInfoStatically;

    protected $guarded=[];

    protected $translatable = ['attribute_name',  'value' ];


    public function product(){
        return $this->belongsTo(Product::class);
    }


}
