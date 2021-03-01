<?php

namespace App\Http\Controllers\Admin\Address;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\City;
use App\Models\Region;
use App\User;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function allRegionsAddress($id)
    {
        // $regions = Region::get();
        // $regions = City::with('regions')->find($id);
        // return $regions;
        $region = Region::find($id);
        $addresses = $region->address;
        $regions = Region::get();
        $users = User::get();
        // return $regions;
        return view('admin.address.show-address', compact('addresses','regions','users'));
    }

    public function allAddress()
    {
        $addresses = Address::get();
        $regions = Region::get();
        $users = User::get();
        // return $users;
        return view('admin.address.show-all-address', compact('regions','addresses','users'));
    }

    public function create(){
        $regions = Region::get();
        $users = User::get();
        return view('admin.address.create-address', compact('regions','users'));
    }

    public function store(Request $request)
    {
        // return $request;
        $data = $request->except('_token');
        Address::insert($data);
        //  return $this->returnSuccessMessage('the category has been successfully saved');
        return redirect('admin/address/all-address')->with('Success', 'Address Has Been Added Successfully');
    }

    public function edit($id){
        //make sure that this id is exist if not return this item is not found
        $address=Address::find($id);
        $regions = Region::get();
        $users = User::get();
        // return $address;
        return view('admin.address.edit-address' ,compact('regions','address', 'users'));
    }

    public function update(Request $request , $id){
        $rules=[
            // "name_en"=>'string|max:100',
            // "name_ar"=>'string|max:100',
            // "photo"=>'image|mimes:png,jpg,jepg|max:1024',
        ];
        $request->validate($rules);
        $data=$request->except('_token','_method');
        $update=Address::where('id','=', $id)->update($data);
        if($update){
            // return redirect()->back()->with('Success','the category has been updated ');
            return redirect('admin/address/all-address')->with('Success', 'Address Has Been Edited Successfully');
        }
        return redirect()->back()->with('Error','failed ');
    }

    public function delete(Request $request)
    {
        $rule=[
            "id"=>'required|exists:addresss,id|integer'
        ];
        $request->validate($rule);
        Address::destroy($request->id);
        return redirect('admin/address/all-address')->with('Success','the address has been deleted successfully');
    }
}
