<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model 
{
    protected $table = 'order_product';   

    protected $fillable = [
        'order_id', 'product_id', 'product_combination_id', 'quantity'
    ];
    
}
