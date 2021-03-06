<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable
{
    //
    use Notifiable ,HasRoles;

    protected $guard_name='admin';
    protected $table = "admins";
    protected $fillable = [
        'name', 'email', 'password','photo','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}
