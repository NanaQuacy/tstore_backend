<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    //
    protected $fillable = [
        'product_id',
        'quantity',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
    ];
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
