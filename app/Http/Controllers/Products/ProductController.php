<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\traits\generalTrait;
use SebastianBergmann\Environment\Runtime;

class ProductController extends Controller
{
    //
    use generalTrait;
    public function show($id)
    {
        $subcategory=Subcategory::find($id);
        $products=$subcategory->product;
        // $brand=Brand::find($id);
        // return $brand;
        return view('admin.products.all-products', compact('products'));
    }

    public function create(){
        $brand=Brand::get();
        $subcategory=Subcategory::get();
        // return $subcategory;
        return view('admin.products.create',compact('brand','subcategory'));
    }

    public function store(Request $request){
        // return $request;
        $rules=[
            "name"=>'required|max:100',
            "price"=>'required|integer',
            "code"=>'required|integer',
            "details"=>'required',
            "brand_id"=>'required|integer|exists:brands,id',
            "subcategory_id"=>'required|exists:subcategories,id',
        ];
        $request->validate($rules);
        $data=$request->except('_token');
        // return $data;
        // $imageName= $this->UploadPhoto($request->photo , 'product');
        // return $imageName;
        // $data=$request->except('photo','_token');
        // $data['photo']=$imageName;
        Product::insert($data);
         return redirect('admin/product/show/'.$request->subcategory_id);
    }

}
