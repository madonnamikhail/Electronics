<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $fillable = [
        'name_en','name_ar','email','nationalID', 'phone','photo','product_id','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at','pivot'
    ];

    public function Products(){
        return $this->hasMany('App\Models\Product','supplier_id');
    }

}
