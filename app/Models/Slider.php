<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Slider extends Model
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes, HasRoles; //spatie;

    protected $fillable = [ 
        'slider_image',
        'slider_header',
        'title',
        'description',
        'button_text',
        'link',
        'status',
    ];

    protected $table = "sliders";
}
