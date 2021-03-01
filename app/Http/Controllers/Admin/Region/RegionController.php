<?php

namespace App\Http\Controllers\Admin\Region;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function allCityRegions($id)
    {
        // $regions = Region::get();
        // $regions = City::with('regions')->find($id);
        // return $regions;
        $city = City::find($id);
        $regions = $city->regions;
        // return $regions;
        return view('admin.region.show-regions', compact('regions'));
    }

    public function allRegions()
    {
        $regions = Region::get();
        $cities = City::get();
        return view('admin.region.show-all-regions', compact('regions','cities'));
    }

    public function create(){
        $cities = City::get();
        return view('admin.region.create-region', compact('cities'));
    }

    public function store(Request $request)
    {
        // return $request;
        $data = $request->except('_token');
        Region::insert($data);
        //  return $this->returnSuccessMessage('the category has been successfully saved');
        return redirect('admin/region/all-region')->with('Success', 'Region Has Been Added Successfully');
    }

    public function edit($id){
        //make sure that this id is exist if not return this item is not found
        $region=Region::find($id);
        $citys = City::get();
        return view('admin.region.edit-region' ,compact('region','citys'));
    }

    public function update(Request $request , $id){
        $rules=[
            // "name_en"=>'string|max:100',
            // "name_ar"=>'string|max:100',
            // "photo"=>'image|mimes:png,jpg,jepg|max:1024',
        ];
        $request->validate($rules);
        $data=$request->except('_token','_method');
        $update=Region::where('id','=', $id)->update($data);
        if($update){
            // return redirect()->back()->with('Success','the category has been updated ');
            return redirect('admin/region/all-region')->with('Success', 'Region Has Been Edited Successfully');
        }
        return redirect()->back()->with('Error','failed ');
    }

    public function delete(Request $request)
    {
        $rule=[
            "id"=>'required|exists:regions,id|integer'
        ];
        $request->validate($rule);
        Region::destroy($request->id);
        return redirect('admin/region/all-region')->with('Success','the region has been deleted successfully');
    }
}
