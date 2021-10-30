<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VariantType extends Model
{
    use HasFactory, SoftDeletes;

    public function variantOptions()
    {
        // one variant type has many variant options
        return $this->hasMany(VariantOption::class, 'product_variant_id', 'id');
    }

    public function product()
    {
        // one variant type only belongs to one product
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    protected $fillable = [
        'variant_name',
    ];

    protected $table = "products_variants_types";
}
