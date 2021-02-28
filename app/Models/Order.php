<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'status','amount','total_price','user_id','promoCodes_id','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at',
    ];

    public function users(){
        return $this->belongsTo('App\Models\User','user_id');
    }

}