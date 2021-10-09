<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageGallery extends Model
{
    use HasFactory, SoftDeletes;

    public function imageProductCombination()
    {
        return $this->hasMany(ImageGalleryProductCombination::class);
    }

    protected $table = "image_galleries";
}
