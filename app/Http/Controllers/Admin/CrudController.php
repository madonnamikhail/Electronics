<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Models\Subcategory;
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

    public function store(MainCategoryRequest $request){

        $imageName= $this->UploadPhoto($request->photo , 'photo');
         $data=$request->except('photo','_token');
         $data['photo']=$imageName;
         Category::insert($data);
         return $this->returnSuccessMessage('the category has been successfully saved');
    }

    public function edit($id){
        //make sure that this id is exist if not return this item is not found
        $category=Category::find($id);
        return view('admin.category.edit-category' ,compact('category'));
    }

    public function update(Request $request , $id){
        $rules=[
            "name_en"=>'string|max:100',
            "name_ar"=>'string|max:100',
            "photo"=>'image|mimes:png,jpg,jepg|max:1024',

        ];
        $request->validate($rules);
        $data=$request->except('_token','_method');
        if($request->has('photo')){
            $imageName= $this->UploadPhoto($request->photo , 'photo');
            $data=$request->except('photo','_token','_method');
            $data['photo']=$imageName;
        }
        $update=Category::where('id','=', $id)->update($data);
        if($update){
            return redirect()->back()->with('Success','the category has been updated ');
        }
        return redirect()->back()->with('Error','failed ');

    }

    public function delete(Request $request){

            $rule=[
                "id"=>'required|exists:categories,id|integer'
            ];
            $request->validate($rule);
            $photoPath=public_path("images\photo\\" . $request->photo);
            // return $photoPath;
            if(file_exists($photoPath)){
               unlink($photoPath);
            }
            Category::destroy($request->id);
            return redirect()->back()->with('Success','the category has been deleted successfully');



        }

        public function subshow($id){
            $categorys=Category::find($id);
            //one-to-many relation
            $sub= $categorys->subcategory;
            // return $sub;
            return view ('admin.category.category-subcat',compact('sub'));
        }

        public function subcreate(){
            $categorys=Category::get();
            return view ('admin.subCategory.subcreate',compact('categorys'));

        }
        public function substore(Request $request)
        {
            $rules=[
                "name_en"=>'required|string|max:100',
                "name_ar"=>'required|string|max:100',
                "category_id"=>'required|exists:categories,id',
                "photo"=>'image|mimes:png,jpg,jepg|max:1024',

            ];
            $request->validate($rules);
            $data=$request->except('_token');
            $imageName= $this->UploadPhoto($request->photo , 'subcategorys');
         $data=$request->except('photo','_token');
         $data['photo']=$imageName;

         Subcategory::insert($data);
         return redirect()->back()->with('Success','The Subcategory succesfully added');
        }


        public function subedit($id){
            $Subcategory=Subcategory::find($id);
            $categoryId=Category::get();
            // return $Subcategory;
            return view('admin.subCategory.subedit' ,compact('Subcategory','categoryId'));
        }

        public function subupdate(Request $request , $id){
            $rules=[
                "name_en"=>'string|max:100',
                "name_ar"=>'string|max:100',
                "photo"=>'image|mimes:png,jpg,jepg|max:1024',
                "category_id"=>'exists:categories,id',


            ];
            $request->validate($rules);
            $data=$request->except('_token','_method');
            if($request->has('photo')){
                $imageName= $this->UploadPhoto($request->photo , 'photo');
                $data=$request->except('photo','_token','_method');
                $data['photo']=$imageName;
            }
            $update=Subcategory::where('id','=', $id)->update($data);
            if($update){
                return redirect()->back()->with('Success','the Sub-Category has been updated ');
            }
            return redirect()->back()->with('Error','failed ');

        }

        public function subdelete(Request $request){
            // return $request;
            $rule=[
                "id"=>'required|exists:subcategories,id|integer'
            ];
            $request->validate($rule);
            $photoPath=public_path("images\subcategorys\\" . $request->photo);
            // return $photoPath;
            if(file_exists($photoPath)){
               unlink($photoPath);
            }
            Subcategory::destroy($request->id);
            return redirect()->back()->with('Success','the SubCategory has been deleted successfully');



        }
}
