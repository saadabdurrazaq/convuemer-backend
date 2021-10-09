<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageGalleryProductCombination extends Model
{
    use HasFactory, SoftDeletes;

    public function imageGallery()
    {
        return $this->belongsTo(ImageGallery::class, 'prod_comb_id', 'id');
    }

    protected $table = "image_galleries_products_combinations";
}
