<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubSubCategory extends Model
{
    use HasFactory, SoftDeletes;

    public function product()
    {
        // one sub sub category has many products
        return $this->hasMany(Product::class);
    }

    public function category()
    {
        // one sub sub category only belongs to one category
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subCategory()
    {
        // one sub sub category only belongs to one sub category
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'subsubcategory_name',
        'subsubcategory_slug',
    ];

    protected $table = "sub_sub_categories";
}
