<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes;

    public function category()
    {
        // one sub category only belongs to one category
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subSubCategory()
    {
        // one sub category has many sub sub categories
        return $this->hasMany(SubSubCategory::class, 'subcategory_id', 'id'); //changed
    }

    protected $fillable = [
        'category_id',
        'subcategory_name',
        'subcategory_slug',
    ];

    protected $table = "sub_categories";
}
