<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    //
    protected $fillable = [
        'name_en','name_ar','photo','category_id', 'created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at'
    ];

    public function category(){
        return $this->belongsTo('App\Models\Category','Category_id');
    }
    public function product(){
        return $this->hasMany('App\Models\Product','subCategory_id');
    }
}
