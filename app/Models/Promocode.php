<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    //
    protected $fillable = [
        'name','discountValue','minOrderValue','maxOrderValue','type','max_usage','max_usage_per_user','start_date','expire_date','created_at','updated_at'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at',
    ];
    public function users()
    {
        return $this->belongsToMany('App\User','user_promocode')->withPivot('order_id');
    }
}
