<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name_en','name_ar','photo','price','code', 'details_en','details_ar','supplier_id','brand_id','subCategory_id','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at','pivot',
    ];


    public function subcategory(){
        return $this->belongsTo('App\Models\Subcategory','subCategory_id');
    }
    public function offers(){
        return $this->belongsToMany('App\Models\Offer','offer_product','product_id','offer_id');
    }

    public function supplier(){
        return $this->belongsTo('App\Models\Supplier','supplier_id');
    }
}
