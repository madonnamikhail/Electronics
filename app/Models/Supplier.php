<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Supplier extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'name_en','name_ar','email','nationalID','password', 'phone','photo','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at','pivot','password',
    ];

    public function Products(){
        return $this->hasMany('App\Models\Product','supplier_id');
    }

}
