<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TotalStockVariantProduct extends Model
{
    use HasFactory, SoftDeletes;

    public function product()
    {
        // one stock variant product only belongs to one product variant
        return $this->belongsTo(ProductCombination::class, 'product_combination_id', 'id');
    }

    protected $fillable = [
        'combination_string',
    ];

    protected $table = "total_stocks_variants_products";
}
