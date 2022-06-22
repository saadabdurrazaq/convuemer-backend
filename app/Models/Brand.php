<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Brand extends Model
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes, HasRoles; //spatie;

    protected $fillable = [
        'brand_name',
        'brand_slug',
        'brand_image',
    ];

    protected $table = "brands";
}
