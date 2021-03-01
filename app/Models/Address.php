<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresss';
    protected $fillable = [
        'flat', 'building','floor','street_en','street_ar','user_id','region_id', 'created_at','updated_at'
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
        return $this->belongsTo('App\Models\Region', 'region_id', 'id');
    }
}
