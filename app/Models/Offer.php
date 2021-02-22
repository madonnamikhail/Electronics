<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    //
    protected $fillable = [
        'title_en','title_ar','discount','details_en','details_ar','photo','start_date','expire_date','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at','pivot',
    ];

    public function products(){
        return $this->belongsToMany('App\Models\Product','offer_product','offer_id','product_id');
    }
}
