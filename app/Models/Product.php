<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public function category()
    {
        // one product only belongs to one category
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subCategory()
    {
        // one product only belongs to one sub category
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }

    public function subSubCategory()
    {
        // one product only belongs to one sub sub category
        return $this->belongsTo(SubSubCategory::class, 'subsubcategory_id', 'id');
    }

    public function variants()
    {
        // one product has many variants types
        return $this->hasMany(VariantType::class); // , 'product_variant_id', 'id'
    }

    public function variantOptions()
    {
        // one category has many sub sub categories
        return $this->hasMany(VariantOption::class);
    }

    public function variantsProd()
    {
        // one product has many product variants
        return $this->hasMany(ProductCombination::class);
    }

    protected $fillable = [
        'product_name',
        'brand_id',
        'category_id',
        'subcategory_id',
        'subsubcategory_id',
        'short_desc',
        'long_desc',
        'min_order',
        'selling_price',
        'product_stock',
        'product_cond',
        'sku',
        'product_length',
        'product_width',
        'product_height',
        'product_weight',
        'metric_mass',
        'status',
        'hot_deals',
        'special_offer',
        'featured',
        'special_deals',
    ];

    protected $table = "products";
}
