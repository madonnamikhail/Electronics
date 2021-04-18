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
        'created_at','updated_at',

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

    public function user()
    {
    return $this->belongsToMany('App\User', 'carts')->withPivot('product_id', 'user_id', 'quantity');
    }
    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'order_product')->withPivot('product_id', 'order_id', 'quantity','payment_method','promocode','status','price','offer_id','price_after_offer_discount');
    }
    public function userRate()
    {
    return $this->belongsToMany('App\User', 'ratings')->withPivot('product_id', 'user_id', 'value','comment','updated_at');
    }

    public function specs()
    {
        // return $this->belongsToMany('App\Models\Spec', 'spec_product')->withPivot('product_id', 'spec_id', 'value');
        return $this->belongsToMany('App\Models\Spec', 'spec_product')->withPivot('value');

    }

}
