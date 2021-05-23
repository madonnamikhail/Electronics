<?php

namespace App\Http\Controllers\SupplierDashboard\SupplierProduct;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\traits\generalTrait;
use Illuminate\Support\Facades\Validator;

class SupplierProductController extends Controller
{
    use generalTrait;
    public function showSupplierProducts()
    {
        $supplier_id = Auth::user()->id;
        $products = Supplier::with('products')->find($supplier_id);
        $brand = Brand::get();
        $subcategorys = Subcategory::get();
        return view('supplier.products.supplier-show-all-products', compact('products','brand','subcategorys'));
    }

    // supplier updates products' status (delayed)
    public function updateProductStatus(Request $request)
    {
        // al ajax msh hywreny al return ella lma 23mel append f 7aga f al ajax nfso
        $product=Product::find($request->product_id);
        $product->status=$request->status;
        $product->save();
        // return $product;
        // return $request->product_id;
    }

    public function create(){
        $brand=Brand::get();
        $subcategory=Subcategory::get();
        $category=Category::get();
        return view('supplier.products.create',compact('brand','subcategory','category'));
    }

    public function store(Request $request){
        // return $request;
        $rules=[
            "name_en"=>'required|max:100',
            "name_ar"=>'required|max:100',
            "price"=>'required',
            "code"=>'required',
            "details_en"=>'required',
            "details_ar"=>'required',
            "photo"=>'required|mimes:png,jpg,jpeg|max:1024',
            "brand_id"=>'required|integer|exists:brands,id',
            "subcategory_id"=>'required|exists:subcategories,id',
        ];
        $request->validate($rules);
        $data=$request->except('_token');
        $imageName= $this->UploadPhoto($request->photo , 'product');
        $data=$request->except('photo','_token');
        $data['photo']=$imageName;
        $data['supplier_id'] = Auth::user()->id;
        Product::insert($data);
        return redirect('supplier/product/show-supplier-products')->with('Success','The product has been added successfully');
    }

    public function edit($id){
        $rules = [
            'id' => 'required|exists:products,id'
        ];
        $idd = [];
        $idd['id'] = $id;
        $validator = Validator::make($idd,$rules);
        if ($validator->fails()) {
            return abort(404);
        }
        $product=Product::find($id);
        $category=Category::get();
        // return $product;
        $brand=Brand::get();
        $subcategory=Subcategory::get();
        return view ('supplier.products.edit',compact('product','brand','subcategory','category'));

    }
    public function update(Request $request , $id)
    {
        $rules=[
            "name_en"=>'required|max:100',
            "name_ar"=>'required|max:100',
            "price"=>'required',
            "code"=>'required',
            "details_en"=>'required',
            "details_ar"=>'required',
            "photo"=>'mimes:png,jpg,jpeg|max:1024',
            "brand_id"=>'required|integer|exists:brands,id',
            "subcategory_id"=>'required|exists:subcategories,id',
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
        $data=$request->except('_token','_method');
        if($request->has('photo')){
            $imageName= $this->UploadPhoto($request->photo , 'product');
            $data=$request->except('photo','_token','_method');
            $data['photo']=$imageName;
        }
        $data['supplier_id'] = Auth::user()->id;
        $update=Product::where('id','=', $id)->update($data);
        if($update){
            return redirect('supplier/product/show-supplier-products')->with('Success','The product has been updated successfully');
        }
        return redirect()->back()->with('Error','failed ');
    }

    public function delete(Request $request){

        $rule=[
            "id"=>'required|exists:products,id|integer'
        ];
        $request->validate($rule);
        $photoPath=public_path("images\product\\" . $request->photo);
        // return $photoPath;
        if(file_exists($photoPath)){
           unlink($photoPath);
        }
        Product::destroy($request->id);
        return redirect('supplier/product/show-supplier-products')->with('Success','The product has been deleted successfully');
    }
}
