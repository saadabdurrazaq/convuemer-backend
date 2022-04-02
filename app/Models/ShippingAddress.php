<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use SoftDeletes; //trash user   

    public function user()  
    {
        // one address only belongs to one user
        return $this->belongsTo('App\Models\User');
    }

    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'id', 'no_ktp'
    ];

    protected $table = "shipping_addresses";
    protected $primaryKey = "id";
}
