<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\traits\generalTrait;

class BrandController extends Controller
{
    //
    use generalTrait;
    public function showall(){
        $brand=Brand::get();
        return view('admin.brand.showAll',compact('brand'));
    }

    public function create(){
       return view('admin.brand.create-brand');
    }

    public function store(Request $request){
        $rules=[
            "name_en"=>'required|string|max:100|unique:brands,name_en',
            "name_ar"=>'required|string|max:100|unique:brands,name_ar',
            "photo"=>'image|mimes:png,jpg,jpeg|max:1024',
        ];
        $request->validate($rules);
        $imageName= $this->UploadPhoto($request->photo , 'brands');
        $data=$request->except('photo','_token');
        $data['photo']=$imageName;
        // return $data;

        Brand::insert($data);
        return redirect('admin/brand/show-all');
     }

    public function edit($id){
        $brand=Brand::find($id);
        // return $brand;
        return view('admin.brand.edit-brand', compact('brand'));

    }

    public function update(Request $request,$id)
    {
        $rules=[
            "name_en"=>'string|max:100',
            "name_ar"=>'string|max:100',
            "photo"=>'image|mimes:png,jpg,jpeg|max:1024',
        ];
        $request->validate($rules);
        $data=$request->except('_token','_method');
        if($request->has('photo')){
            $imageName= $this->UploadPhoto($request->photo , 'brands');
            $data=$request->except('photo','_token','_method');
            $data['photo']=$imageName;
        }
        $update=Brand::where('id','=', $id)->update($data);
        if($update){
            return redirect('admin/brand/show-all');
        }
        return redirect()->back()->with('Error','failed ');
    }

    public function delete(Request $request){

        $rule=[
            "id"=>'required|exists:brands,id|integer'
        ];
        $request->validate($rule);
        $photoPath=public_path("images\brands\\" . $request->photo);
        // return $photoPath;
        if(file_exists($photoPath)){
           unlink($photoPath);
        }
        Brand::destroy($request->id);
        return redirect('admin/brand/show-all');



    }
}
