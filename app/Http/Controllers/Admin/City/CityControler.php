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
        // return $request;
        $rules=[
            "name_en"=>"unique:citys,name_en|alpha_num|required",
            "name_ar"=>"unique:citys,name_ar|alpha_num|required",
            "lat"=>"unique:citys,lat|alpha_num|required",
            "longg"=>"unique:citys,longg|alpha_num|required",
        ];
        $request->validate($rules);
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
            "name_en"=>"alpha_num|required",
            "name_ar"=>"alpha_num|required",
            "lat"=>"alpha_num|required",
            "longg"=>"alpha_num|required",
        ];
        $request->validate($rules);
        $data=$request->except('_token','_method');
        $update=City::where('id','=', $id)->update($data);
        if($update){
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
