<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCombOrder extends Model 
{
    protected $table = 'order_product_combination';   

    protected $fillable = [
        'order_id', 'product_id', 'product_combination_id', 'quantity'
    ];
    
}
