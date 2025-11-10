<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    //
    protected $fillable = [
        'name',
        'business_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
