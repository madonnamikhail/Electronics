<?php

namespace App\Http\Controllers\Promocode;

use App\Http\Controllers\Controller;
use App\Models\Promocode;
use Illuminate\Http\Request;
use App\traits\generalTrait;

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
        // return $request;
        $rules=[
            "name"=>'required|max:100',
            "discountValue"=>'required|max:100',
            "minOrderValue"=>'required|integer',
            "maxOrderValue"=>'required|integer',
            "start_date"=>'required',
            "expire_date"=>'required',
        ];
        $request->validate($rules);
        $data=$request->except('_token');
    //     $imageName= $this->UploadPhoto($request->photo , 'promocode');
    //  $data=$request->except('photo','_token');
    //  $data['photo']=$imageName;

     Promocode::insert($data);
     return redirect('admin/promocode/all-promocodes');
    }

    public function edit($id){
        $promo=Promocode::find($id);
        return view ('admin.promocode.edit-promocode',compact('promo'));
    }

    public function update(Request $request , $id){
        $rules=[
            "name"=>'required|max:100',
            "discountValue"=>'required|max:100',
            "minOrderValue"=>'required|integer',
            "maxOrderValue"=>'required|integer',
            "start_date"=>'required',
            "expire_date"=>'required',
        ];
        $request->validate($rules);
        $data=$request->except('_token','_method');
        if($request->has('photo')){
            $imageName= $this->UploadPhoto($request->photo , 'promocode');
            $data=$request->except('photo','_token','_method');
            $data['photo']=$imageName;
        }
        $update=Promocode::where('id','=', $id)->update($data);
        if($update){
            return redirect('admin/promocode/all-promocodes');
        }
        return redirect()->back()->with('Error','failed ');

    }

    public function delete(Request $request){

        $rule=[
            "id"=>'required|exists:promocodes,id|integer'
        ];
        $request->validate($rule);
        // $photoPath=public_path("images\promocode\\" . $request->photo);
        // // return $photoPath;
        // if(file_exists($photoPath)){
        //    unlink($photoPath);
        // }
        Promocode::destroy($request->id);
        return redirect('admin/promocode/all-promocodes');



    }
}
