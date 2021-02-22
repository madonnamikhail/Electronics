<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\traits\generalTrait;
use SebastianBergmann\Environment\Runtime;
use LaravelLocalization;

class ProductController extends Controller
{
    //
    use generalTrait;

    public function showall(){
        $products=Product::get();
        // $i=0;
        // foreach($products as $product){
        //     $subcategory[$i]=Subcategory::select('name_en','name_ar')->find($product->subCategory_id);
        //     $brand[$i]=Brand::select('name_en','name_ar')->find($product->brand_id);
        //     // $offer[$i]=Offer::select('title_en','title_ar')->find($product->offer_id);
        //     $i++;
        // }

        return view('admin.products.show-all' , compact('products'));
        // return $products;
    }


    public function show($id)
    {
        // $products=Product::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','details_'.LaravelLocalization::getCurrentLocale().' as details','price','code','brand_id ','subCategory_id')->where('subCategory_id','=',$id)->get();
        // return $products;
        $subcategory=Subcategory::find($id);
        $products=$subcategory->product;

        // $i=0;
        // foreach($products as $product){
        //     $subcategory[$i]=Subcategory::select('name_en','name_ar')->find($product->subCategory_id);
        //     $brand[$i]=Brand::select('name_en','name_ar')->find($product->brand_id);
        //     $i++;
        // }
        // $brand=Brand::find($id);
        // return $brand;
        return view('admin.products.all-products', compact('products'));
    }

    public function create(){
        $brand=Brand::get();
        $subcategory=Subcategory::get();
        // return $subcategory;
        $category=Category::get();
        $supplier=Supplier::get();
        // return $subcategory;
        return view('admin.products.create',compact('brand','subcategory','supplier','category'));
    }

    public function store(Request $request){
        // return $request;
        $rules=[
            "name_en"=>'required|max:100',
            "name_ar"=>'required|max:100',
            "price"=>'required|integer',
            "code"=>'required|integer',
            "details_en"=>'required',
            "details_ar"=>'required',
            "photo"=>'image|mimes:png,jpg,jepg|max:1024',
            "brand_id"=>'required|integer|exists:brands,id',
            "subcategory_id"=>'required|exists:subcategories,id',
        ];
        $request->validate($rules);
        $data=$request->except('_token');
        $imageName= $this->UploadPhoto($request->photo , 'product');
        $data=$request->except('photo','_token');
        $data['photo']=$imageName;
        Product::insert($data);
         return redirect('admin/product/show-all');
    }
    public function edit($id){
        $product=Product::find($id);
        // return $product;
        $brand=Brand::get();
        $subcategory=Subcategory::get();
        $offer=Offer::get();
        return view ('admin.products.edit',compact('product','brand','subcategory','offer'));

    }
    public function update(Request $request , $id)
    {
        $rules=[
            "name_en"=>'string|max:100',
            "name_ar"=>'string|max:100',
            "price"=>'integer',
            "code"=>'integer',
            "offer_id"=>'integer|exists:offers,id',
            "brand_id"=>'integer|exists:brands,id',
            "subcategory_id"=>'exists:subcategories,id',
        ];
        $request->validate($rules);
        $data=$request->except('_token','_method');
        if($request->has('photo')){
            $imageName= $this->UploadPhoto($request->photo , 'product');
            $data=$request->except('photo','_token','_method');
            $data['photo']=$imageName;
        }
        $update=Product::where('id','=', $id)->update($data);
        if($update){
            return redirect('admin/product/show-all');
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
        return redirect('admin/product/show-all');



    }

}
