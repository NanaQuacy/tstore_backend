<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    // Reference types
    const REFERENCE_TYPE_SALE = 'sale';
    const REFERENCE_TYPE_TRANSFER = 'transfer';
    const REFERENCE_TYPE_ADJUSTMENT = 'adjustment';
    const REFERENCE_TYPE_RETURN = 'return';

    protected $fillable = [
        'product_id',
        'business_id',
        'transaction_type',
        'volume_type',
        'volume_quantity',
        'quantity',
        'previous_quantity',
        'new_quantity',
        'reference_type',
        'reference_id',
        'description',
        'created_by',
    ];

    /**
     * Get the product that owns this stock transaction.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the business that owns this stock transaction.
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Get the user who created this stock transaction.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to filter by reference type.
     */
    public function scopeByReferenceType($query, $referenceType)
    {
        return $query->where('reference_type', $referenceType);
    }

    /**
     * Scope to filter by reference ID.
     */
    public function scopeByReferenceId($query, $referenceId)
    {
        return $query->where('reference_id', $referenceId);
    }

    /**
     * Scope to filter by both reference type and ID.
     */
    public function scopeByReference($query, $referenceType, $referenceId)
    {
        return $query->where('reference_type', $referenceType)
                    ->where('reference_id', $referenceId);
    }
}
