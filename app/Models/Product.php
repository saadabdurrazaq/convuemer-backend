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

    public function variantType()
    {
        // one product has many variants types
        return $this->hasMany(VariantType::class);
    }

    public function productCombination()
    {
        // one product has many product variants
        return $this->hasMany(ProductCombination::class);
    }

    protected $fillable = [
        'product_name',
    ];

    protected $table = "products";
}
