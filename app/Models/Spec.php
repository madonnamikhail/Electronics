<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spec extends Model
{
    protected $fillable = [
        'name','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at',

    ];

    public function products()
    {
        // return $this->belongsToMany('App\Models\Product', 'spec_product')->withPivot('product_id', 'spec_id', 'value');
        return $this->belongsToMany('App\Models\Product', 'spec_product')->withPivot('value');

    }
}
