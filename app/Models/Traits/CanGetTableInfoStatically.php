<?php

namespace App\Models\Traits;

use App\Models\Product;

trait CanGetTableInfoStatically
{
    public static function tableName(){
        return (new static())->getTable();
    }
}
