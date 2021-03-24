<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','photo','code','status','phone','email_verified_at','created_at','updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsToMany('App\Models\Product', 'carts')->withPivot('product_id', 'user_id', 'quantity');
    }

    public function orders(){
        return $this->hasMany('App\Models\Order','user_id');
    }
    public function productRate()
    {
        return $this->belongsToMany('App\Models\Product', 'ratings')->withPivot('product_id', 'user_id', 'value','comment','updated_at');
    }
    // public function sendEmailVerificationNotification()
    // {
    //     $this->notify(new MyNotification);
    // }
    public function promocodes()
    {
        return $this->belongsToMany('App\Models\Promocode','user_promocode')->withPivot('order_id');
    }

}
