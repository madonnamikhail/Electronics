<?php

namespace App\Http\Controllers\Promocode;

use App\Http\Controllers\Controller;
use App\Models\Promocode;
use Illuminate\Http\Request;
use App\traits\generalTrait;
use Illuminate\Support\Facades\Validator;

class PromocodeController extends Controller
{
    //
    use generalTrait;
    public function allPromocodes(){
        $promo=Promocode::get();
        return view('admin.promocode.all-promocodes',compact('promo'));
    }

    public function create(){
        return view('admin.promocode.create-promocode');
    }

    public function store(Request $request){
        $rules=[
            "name"=>'required|max:100',
            "minOrderValue"=>'required|string|min:1',
            "maxOrderValue"=>'required|string|gt:minOrderValue',
            "type"=>'required|integer|min:0|max:1',
            "discountValue"=>$request->type == 1 ? 'required|numeric|max:100|min:1' : 'required|numeric',
            "max_usage"=>'required|integer|gt:max_usage_per_user',
            "max_usage_per_user"=>'required|integer|min:1',
            "start_date"=>'required|date|before:expire_date',
            "expire_date"=>'required|date|after:start_date'
        ];
        $request->validate($rules);
        $data=$request->except('_token');

        if($request->type){
            $data=$request->except('_token','discountValue');
            $data['discountValue'] = $request->discountValue . '%';
        }

        Promocode::insert($data);
        return redirect('admin/promocode/all-promocodes')->with('Success','The promocode has been added successfully');
    }

    public function edit($id){
        $rules = [
            'id' => 'required|exists:promocodes,id'
        ];
        $idd = [];
        $idd['id'] = $id;
        $validator = Validator::make($idd,$rules);
        if ($validator->fails()) {
            return abort(404);
        }
        $promo=Promocode::find($id);
        return view ('admin.promocode.edit-promocode',compact('promo'));
    }

    public function update(Request $request , $id){
        $rules=[
            "name"=>'required|max:100',
            "discountValue"=>'required|numeric',
            "minOrderValue"=>'required|string|min:1',
            "maxOrderValue"=>'required|string|gt:minOrderValue',
            "type"=>'required|integer|min:0|max:1',
            "max_usage"=>'required|integer|gt:max_usage_per_user',
            "max_usage_per_user"=>'required|integer|min:1',
            "start_date"=>'required|date|before:expire_date',
            "expire_date"=>'required|date|after:start_date'
        ];
        $request->validate($rules);
        $ruless = [
            'id' => 'required|exists:products,id'
        ];
        $idd = [];
        $idd['id'] = $id;
        $validator = Validator::make($idd,$ruless);
        if ($validator->fails()) {
            return abort(404);
        }
        // return $request;
        $data=$request->except('_token','_method');
        if($request->type){
            $data=$request->except('_token','discountValue','_method');
            $data['discountValue'] = $request->discountValue . '%';
        }
        // return $data;
        $update=Promocode::where('id','=', $id)->update($data);
        if($update){
            return redirect('admin/promocode/all-promocodes')->with('Success','The promocode has been updated successfully');
        }
        return redirect()->back()->with('Error','failed ');

    }

    public function delete(Request $request){

        $rule=[
            "id"=>'required|exists:promocodes,id|integer'
        ];
        $request->validate($rule);
        $photoPath=public_path("images\promocode\\" . $request->photo);
        // return $photoPath;
        if(file_exists($photoPath)){
           unlink($photoPath);
        }
        Promocode::destroy($request->id);
        return redirect('admin/promocode/all-promocodes')->with('Success','The promocode has been deleted successfully');



    }
}
