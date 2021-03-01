<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    protected $table = 'static_pages';
    protected $fillable = [
        'title_en', 'title_ar','details_en', 'details_ar','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'created_at'
    ];
}
