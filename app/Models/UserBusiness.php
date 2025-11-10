<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBusiness extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'business_id',
        'is_active',
    ];

    /**
     * Get the user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the business.
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
