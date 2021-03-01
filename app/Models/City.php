<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'citys';
    protected $fillable = [
        'name_en', 'name_ar','lat','longg', 'created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'created_at'
    ];

    public function regions()
    {
        return $this->hasMany('App\Models\Region', 'city_id', 'id');
    }
}
