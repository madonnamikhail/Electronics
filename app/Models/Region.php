<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';
    protected $fillable = [
        'name_en', 'name_ar','lat','longg', 'city_id','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'created_at'
    ];

    public function cities()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    public function address()
    {
        return $this->hasMany('App\Models\Address', 'region_id', 'id');
    }
}
