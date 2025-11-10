<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'business_code',
        'description',
        'address',
        'phone',
        'email',
        'website',
        'logo',
        'banner',
        'is_active',
    ];

    /**
     * Get the creator of the business.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the users associated with this business.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_businesses')
                    ->withPivot('is_active')
                    ->withTimestamps();
    }

    /**
     * Get the products for this business.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
