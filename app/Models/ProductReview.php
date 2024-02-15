<?php

namespace App\Models;

use App\Models\Traits\CanGetTableInfoStatically;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProductReview extends Model
{
    use HasFactory, HasTranslations, CanGetTableInfoStatically;

    protected $guarded=[];

    protected $translatable = [];


    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }



}
