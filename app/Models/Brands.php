<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    //
    protected $fillable = [
        'name',
        'business_id',
        'category_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
    ];
}
