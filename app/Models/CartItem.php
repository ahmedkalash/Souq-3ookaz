<?php

namespace App\Models;

use App\Models\Traits\CanGetTableInfoStatically;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory, CanGetTableInfoStatically;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
