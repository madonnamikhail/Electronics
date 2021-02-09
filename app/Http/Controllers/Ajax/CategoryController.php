<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\traits\generalTrait;

class CategoryController extends Controller
{
    //
    use generalTrait;
    public function create(){
        return view('admin.ajax.category.create-category');
    }

    public function store(Request $request){


        $imageName= $this->UploadPhoto($request->photo , 'photo');

        Category::create([
            'name_en' =>$request->name_en,
            'name_ar' =>$request->name_ar,
            'photo' =>$imageName,

        ]);

    }
}
