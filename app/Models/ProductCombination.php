<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCombination extends Model
{
    use HasFactory, SoftDeletes;

    public function product()  
    {
        // one variant product () only belongs to one product
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function variantProductStock()
    {
        // one variant product has many stocks
        return $this->hasMany(TotalStockVariantProduct::class);
    }

    public function orders() { 
        return $this->belongsToMany('App\Models\Order');
    } 

    protected $fillable = [
        'combination_string', 
        'product_slug',
        'url',
        'url_id',
        'unique_string_id',
        'product_key'
    ];

    protected $table = "products_combinations";
}
