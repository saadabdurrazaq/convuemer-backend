<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class SubCategory extends Model
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes, HasRoles; //spatie;

    public function product() 
    {
        // one sub category has many products
        return $this->hasMany(Product::class);
    }

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
