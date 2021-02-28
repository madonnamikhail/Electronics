<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\traits\generalTrait;

class SupplierController extends Controller
{
    //
    use generalTrait;
    public function allsuppliers(){
        $suppliers=Supplier::get();
        return view('admin.supplier.all-suppliers',compact('suppliers'));
    }

    public function SupplierProducts($id){
        //return products only
        $suppliers=Supplier::find($id);
        $products= $suppliers->products;
        $brand=Brand::get();
        $subcategorys=Subcategory::get();
        $suppliers=Supplier::get();
        
        return view('admin.supplier.supplier-products',compact('products','brand','subcategorys','suppliers'));
    }

    public function create(){
        $products=Product::get();
        return view('admin.supplier.create',compact('products'));
    }
    public function store(Request $request){
        // $rules=[
        //     "name_en"=>'required|max:100',
        //     "name_ar"=>'required|max:100',
        //     "email"=>'required|email',
        //     "nationalID "=>'required|integer',
        //     "phone"=>'required',
        //     "photo"=>'image|mimes:png,jpg,jepg|max:1024',
        //     "product_id"=>'required|exists:products,id',
        // ];
        // $request->validate($rules);
        $data=$request->except('_token');
        $imageName= $this->UploadPhoto($request->photo , 'supplier');
        $data=$request->except('photo','_token');
        $data['photo']=$imageName;
        Supplier::insert($data);
        return redirect('admin/supplier/all-suppliers');
    }

    public function edit($id){
        $supplier=Supplier::find($id);
        $product=Product::get();
        return view('admin.supplier.edit', compact('supplier','product'));
    }
    public function update(Request $request , $id){
        // $rules=[
        //     "name_en"=>'required|max:100',
        //     "name_ar"=>'required|max:100',
        //     "email"=>'required|email',
        //     "nationalID "=>'required|integer',
        //     "phone"=>'required',
        //     "photo"=>'image|mimes:png,jpg,jepg|max:1024',
        //     "product_id"=>'required|exists:products,id',
        // ];
        // $request->validate($rules);
        $data=$request->except('_token','_method');
        // return $data;
        if($request->has('photo')){
            $imageName= $this->UploadPhoto($request->photo , 'supplier');
            $data=$request->except('photo','_token','_method');
            $data['photo']=$imageName;
        }
        $update=Supplier::where('id','=', $id)->update($data);
        if($update){
            return redirect('admin/supplier/all-suppliers');
        }
        return redirect()->back()->with('Error','failed ');

    }

    public function delete(Request $request){
        // return $request;
        $rule=[
            "id"=>'required|exists:suppliers,id|integer'
        ];
        $request->validate($rule);
        $photoPath=public_path("images\supplier\\" . $request->photo);
        // return $photoPath;
        if(file_exists($photoPath)){
           unlink($photoPath);
        }
        Supplier::destroy($request->id);
        return redirect('admin/supplier/all-suppliers');
    }



}
