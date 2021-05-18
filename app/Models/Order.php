<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'status','amount','total_price','user_id','address_id','promoCodes_id','total_price','total_price_after_promocode','created_at','updated_at'
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
    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'order_product')->withPivot('product_id', 'order_id', 'quantity','payment_method','promocode','status','price','offer_id','price_after_offer_discount');
    }
 

}
