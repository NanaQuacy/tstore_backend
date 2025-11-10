<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    //
    protected $fillable = [
        'business_id',
        'name',
        'short_name',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
    ];
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
