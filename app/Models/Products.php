<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    protected $fillable = [
        'name',
        'business_id',
        'category_id',
        'brand_id',  
        'unit_id',
        'barcode',
        'qrcode',
        'quantity_per_box',                                                                                    
        'description',
        'is_active',
        'is_featured',
        'has_variants',
        'has_images',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
    ];
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
    public function brand(){
        return $this->belongsTo(Brands::class);
    }
    public function unit()
    {
        return $this->belongsTo(Units::class);
    }
    public function productPricing()
    {
        return $this->hasOne(ProductPricing::class);
    }
    public function productStock()
    {
        return $this->hasOne(ProductStock::class);
    }
}
