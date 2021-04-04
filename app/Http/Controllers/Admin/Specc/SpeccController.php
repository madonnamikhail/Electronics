<?php

namespace App\Http\Controllers\Admin\Specc;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Spec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpeccController extends Controller
{
    public function allSpeccs()
    {
        $speccs = Spec::get();
        return view('admin.specc.show-speccs', compact('speccs'));
    }

    public function create(){
        return view('admin.specc.create-specc');
    }

    public function store(Request $request)
    {
        // return $request;
        $rules=[
            "name"=>"unique:specs,name|string|required",
        ];
        $request->validate($rules);
        $data = $request->except('_token');
        Spec::insert($data);
        //  return $this->returnSuccessMessage('the category has been successfully saved');
        return redirect('admin/specc/all-speccs')->with('Success', 'Spec Has Been Added Successfully');
    }

    public function edit($id){
        $rules = [
            'id' => 'required|exists:specs,id'
        ];
        $idd = [];
        $idd['id'] = $id;
        $validator = Validator::make($idd,$rules);
        if ($validator->fails()) {
            return abort(404);
        }
        //make sure that this id is exist if not return this item is not found
        $specc=Spec::find($id);
        return view('admin.specc.edit-specc' ,compact('specc'));
    }

    public function update(Request $request , $id){
        $rules=[
            "name"=>"unique:specs,name|string|required",
        ];
        $request->validate($rules);
        $ruless = [
            'id' => 'required|exists:specs,id'
        ];
        $idd = [];
        $idd['id'] = $id;
        $validator = Validator::make($idd,$ruless);
        if ($validator->fails()) {
            return abort(404);
        }
        $data=$request->except('_token','_method');
        $update=Spec::where('id','=', $id)->update($data);
        if($update){
            return redirect('admin/specc/all-speccs')->with('Success', 'Spec Has Been Edited Successfully');
        }
        return redirect()->back()->with('Error','failed ');
    }

    public function delete(Request $request)
    {
        $rule=[
            "id"=>'required|exists:specs,id|integer'
        ];
        $request->validate($rule);
        Spec::destroy($request->id);
        return redirect('admin/specc/all-speccs')->with('Success','Spec has been deleted successfully');
    }

    public function addSpecToProduct()
    {
        $products = Product::get();
        $speccs = Spec::get();
        return view('admin.specc.product-spec',compact('products','speccs'));
    }
    public function storeSpecToProduct(Request $request)
    {
        $rules=[
            "product_id"=>"required|exists:products,id|integer",
            "spec_id"=>"required|exists:specs,id|integer",
            "value"=>"required|string",
        ];
        $request->validate($rules);
        // return $request;
        $product = Product::find($request->product_id);
        $data = $request->except('_token');
        $product->specs()->attach($request->spec_id, $data);
        return redirect('admin/specc/all-speccs')->with('Success','Spec has been added to the product successfully');
    }
}
