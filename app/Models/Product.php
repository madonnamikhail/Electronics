<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name','price','code', 'details','brand_id','subCategory_id','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at'
    ];


    public function subcategory(){
        return $this->belongsTo('App\Models\Subcategory','subCategory_id');
    }
}
