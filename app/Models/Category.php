<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Category extends Model
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes, HasRoles; //spatie;

    public function product()
    {
        // one category has many products
        return $this->hasMany(Product::class);
    }

    public function subCategory() 
    {
        // one category has many sub categories
        return $this->hasMany(SubCategory::class);
    }

    public function subSubCategory()
    {
        // one category has many sub sub categories
        return $this->hasMany(SubSubCategory::class);
    }

    protected $fillable = [
        'category_name',
        'category_slug',
        'category_icon',
    ];

    protected $table = "categories";
}
