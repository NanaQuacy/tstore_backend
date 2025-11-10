<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPricing extends Model
{
    //
    protected $fillable = [
        'product_id',
        'unit_stock_price',
        'box_stock_price',
        'retail_price',
        'min_wholesale_price',
        'max_wholesale_price',
        'box_selling_price',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
    ];
}
