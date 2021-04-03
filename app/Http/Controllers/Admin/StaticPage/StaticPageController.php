<?php

namespace App\Http\Controllers\Admin\StaticPage;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    // 'title_en', 'title_ar','details_en', 'details_ar','created_at','updated_at'
    public function show(){
        $staticPages=StaticPage::get();
         return view('admin.staticPage.all-staticPages' , compact('staticPages'));
    }

    public function create(){
        return view('admin.staticPage.create-staticPage');
    }

    public function store(Request $request)
    {
        // return $request;
         $data=$request->except('_token');
         StaticPage::insert($data);
        //  return $this->returnSuccessMessage('the category has been successfully saved');
        return redirect('admin/staticPage/all-staticPages')->with('Success', 'staticPage Has Been Added Successfully');
    }

    public function edit($id){
        //make sure that this id is exist if not return this item is not found
        $staticPage=StaticPage::find($id);
        return view('admin.staticPage.edit-staticPage' ,compact('staticPage'));
    }

    public function update(Request $request , $id){
        $rules=[
            // "name_en"=>'string|max:100',
            // "name_ar"=>'string|max:100',
        ];
        $request->validate($rules);
        $data=$request->except('_token','_method');
        $update=StaticPage::where('id','=', $id)->update($data);
        if($update){
            // return redirect()->back()->with('Success','the category has been updated ');
            return redirect('admin/staticPage/all-staticPages')->with('Success', 'staticPage Has Been Edited Successfully');
        }
        return redirect()->back()->with('Error','failed ');

    }

    public function delete(Request $request)
    {
        $rule=[
            "id"=>'required|exists:staticPages,id|integer'
        ];
        $request->validate($rule);
        StaticPage::destroy($request->id);
        return redirect()->back()->with('Success','the staticPage has been deleted successfully');
    }
}
