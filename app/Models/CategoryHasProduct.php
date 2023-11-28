<?php

namespace App\Models;

use App\Models\Traits\CanGetTableInfoStatically;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CategoryHasProduct extends Model
{
    use HasFactory, HasTranslations, CanGetTableInfoStatically;

    protected $guarded=[];

    protected $translatable = [ ];

}
