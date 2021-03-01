<?php

namespace App\Http\Controllers\Admin\City;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityControler extends Controller
{
    public function allCities()
    {
        $cities = City::get();
        return view('admin.city.show-cities', compact('cities'));
    }

    public function create(){
        return view('admin.city.create-city');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        City::insert($data);
        //  return $this->returnSuccessMessage('the category has been successfully saved');
        return redirect('admin/city/all-cities')->with('Success', 'City Has Been Added Successfully');
    }

    public function edit($id){
        //make sure that this id is exist if not return this item is not found
        $city=City::find($id);
        return view('admin.city.edit-city' ,compact('city'));
    }

    public function update(Request $request , $id){
        $rules=[
            // "name_en"=>'string|max:100',
            // "name_ar"=>'string|max:100',
            // "photo"=>'image|mimes:png,jpg,jepg|max:1024',

        ];
        $request->validate($rules);
        $data=$request->except('_token','_method');
        $update=City::where('id','=', $id)->update($data);
        if($update){
            // return redirect()->back()->with('Success','the category has been updated ');
            return redirect('admin/city/all-cities')->with('Success', 'City Has Been Edited Successfully');
        }
        return redirect()->back()->with('Error','failed ');

    }

    public function delete(Request $request)
    {
        $rule=[
            "id"=>'required|exists:citys,id|integer'
        ];
        $request->validate($rule);
        City::destroy($request->id);
        return redirect('admin/city/all-cities')->with('Success','the city has been deleted successfully');
    }
}
