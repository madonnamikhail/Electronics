<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    //
    public function store(Request $request){


        // $imageName= $this->UploadPhoto($request->photo , 'photo');

        Subcategory::create([
            'name' =>$request->name,
            'category_id'=>$request->category_id,
            // 'photo' =>$imageName,

        ]);

    }
}
