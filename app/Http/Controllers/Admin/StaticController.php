<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;

class StaticController extends Controller
{
    //
    public function show(){
        $staticPages=StaticPage::get();
         return view('admin.staticPage.all-staticPages' , compact('staticPages'));
    }
}
