<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\traits\generalTrait;

class CrudController extends Controller
{
    //for categories
    use generalTrait;
    public function show(){
        $categorys=Category::Select('id','name_en','name_ar','photo')->get();
         return view('admin.category.all-category' , compact('categorys'));
    }

    public function create(){
        return view('admin.category.create-category');
    }
}
