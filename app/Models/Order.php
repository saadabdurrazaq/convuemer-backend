<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model 
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';     

    protected $fillable = [
        'user_id', 'total_bill', 'invoice_number', 'status'
    ];

    // orders table trying to get access to users table
    public function user() { 
        return $this->belongsTo('App\Models\User');
    }

    // orders table trying to get access to order_product table 
    public function products() { 
        //$orderProduct = Schema::getColumnListing('order_product'); // get all fields from order_product table
        return $this->belongsToMany('App\Models\Product')->withPivot('quantity');
    }

    // orders table trying to get access to order_product_combination table
    public function variantsProd() { 
        return $this->belongsToMany('App\Models\ProductCombination')->withPivot('quantity');;
    }
}
