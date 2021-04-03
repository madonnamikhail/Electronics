<?php

namespace App\Http\Controllers\Admin\Statics;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    //
    public function show(){
        $staticPages=StaticPage::get();
         return view('admin.staticPage.all-staticPages' , compact('staticPages'));
    }
    public function create(){
        return view('admin.staticPage.create-staticPages');
    }

    public function store(Request $request)
    {
        // return $request;
        $rules=[
            "title_en"=>"unique:static_pages,title_en|string|required",
            "title_ar"=>"unique:static_pages,title_ar|string|required",
            "details_en"=>"unique:static_pages,details_en|string|required",
            "details_ar"=>"unique:static_pages,details_ar|string|required",
        ];
        $request->validate($rules);
         $data=$request->except('_token');
         StaticPage::insert($data);
        //  return $this->returnSuccessMessage('the category has been successfully saved');
        return redirect('admin/staticPages/show')->with('Success', 'staticPage Has Been Added Successfully');
    }

    public function edit($id){
        //make sure that this id is exist if not return this item is not found
        $staticPage=StaticPage::find($id);
        return view('admin.staticPage.edit-staticPages' ,compact('staticPage'));
    }

    public function update(Request $request , $id){
        $rules=[
            "title_en"=>"string|required",
            "title_ar"=>"string|required",
            "details_en"=>"string|required",
            "details_ar"=>"string|required",
        ];
        $request->validate($rules);
        $data=$request->except('_token','_method');
        $update=StaticPage::where('id','=', $id)->update($data);
        if($update){
            return redirect('admin/staticPages/show')->with('Success', 'staticPage Has Been Edited Successfully');
        }
        return redirect()->back()->with('Error','failed ');

    }

    public function delete(Request $request)
    {
        $rule=[
            "id"=>'required|exists:static_pages,id|integer'
        ];
        $request->validate($rule);
        StaticPage::destroy($request->id);
        return redirect()->back()->with('Success','the staticPage has been deleted successfully');
    }
}
