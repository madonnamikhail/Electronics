<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Spec;
use App\Models\Subcategory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\traits\generalTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Environment\Runtime;
use LaravelLocalization;

class ProductController extends Controller
{
    //
    use generalTrait;

    public function showall(){
        $products=Product::get();
        $brand=Brand::get();
        $subcategorys=Subcategory::get();
        $suppliers=Supplier::get();
        return view('admin.products.show-all' , compact('products','brand','subcategorys','suppliers'));
        // return $products;
    }
    public function show($id)
    {
        // $products=Product::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','details_'.LaravelLocalization::getCurrentLocale().' as details','price','code','brand_id ','subCategory_id')->where('subCategory_id','=',$id)->get();
        // return $products;
        $rules = [
            'id' => 'required|exists:subcategories,id'
        ];
        $idd = [];
        $idd['id'] = $id;
        $validator = Validator::make($idd,$rules);
        if ($validator->fails()) {
            return abort(404);
        }
        $subcategory=Subcategory::find($id);
        $products=$subcategory->product;
        $brand=Brand::get();
        $subcategorys=Subcategory::get();
        $suppliers=Supplier::get();
        return view('admin.products.all-products', compact('products','brand','subcategorys','suppliers'));
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
            "price"=>'required',
            "code"=>'required',
            "details_en"=>'required',
            "details_ar"=>'required',
            "photo"=>'required|mimes:png,jpg,jpeg|max:1024',
            "brand_id"=>'required|integer|exists:brands,id',
            "supplier_id"=>'required|integer|exists:suppliers,id',
            "subcategory_id"=>'required|exists:subcategories,id',
        ];
        $request->validate($rules);
        $data=$request->except('_token');
        $imageName= $this->UploadPhoto($request->photo , 'product');
        $data=$request->except('photo','_token');
        $data['photo']=$imageName;
        Product::insert($data);
        return redirect('admin/product/show-all')->with('Success','The product has been added successfully');
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
        $supplier=Supplier::get();
        // return $product;
        $brand=Brand::get();
        $subcategory=Subcategory::get();
        $offer=Offer::get();
        $specss=DB::select(
            "SELECT
            `spec_product`.`spec_id`,`spec_product`.`product_id`,`spec_product`.`value`,`specs`.*

        FROM
            `spec_product`
        JOIN
            `specs`
        ON
            `spec_product`.`spec_id` = `specs`.`id`
        WHERE
            `spec_product`.`product_id` = $id ");
        return view ('admin.products.edit',compact('product','brand','subcategory','offer','category','supplier','specss'));

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
            "supplier_id"=>'required|integer|exists:suppliers,id',
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
        $update=Product::where('id','=', $id)->update($data);
        if($update){
            return redirect('admin/product/show-all')->with('Success','The product has been updated successfully');
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
        return redirect('admin/product/show-all')->with('Success','The product has been deleted successfully');
    }
    public function showProductSpec($id)
    {
        $ruless = [
            'id' => 'required|exists:products,id'
        ];
        $idd = [];
        $idd['id'] = $id;
        $validator = Validator::make($idd,$ruless);
        if ($validator->fails()) {
            return abort(404);
        }
        $product_specs=Product::with('specs')->find($id);
        // return $product_specs;
        return view('admin.products.product-speccs',compact('product_specs'));
    }
    public function editProductSpec($product_id,$spec_id)
    {
        $ruless = [
            'product_id' => 'required|exists:products,id',

            'spec_id' => 'required|exists:specs,id',

        ];
        $idd = [];
        $idd['spec_id'] = $spec_id;
        $idd['product_id'] = $product_id;
        $validator = Validator::make($idd,$ruless);
        if ($validator->fails()) {
            return abort(404);
        }

        $specss=DB::select(
        "SELECT
        `spec_product`.`spec_id`,`spec_product`.`product_id`,`spec_product`.`value`,`specs`.*

    FROM
        `spec_product`
    JOIN
        `specs`
    ON
        `spec_product`.`spec_id` = `specs`.`id`
    WHERE
        `spec_product`.`product_id` = $product_id AND `spec_product`.`spec_id` = $spec_id");
        // return $specs;
        // $specs=Spec::with('products')->find($spec_id);
        // foreach($specs->products as $specProduct){
        //     return $specProduct->id;
        // }
        // return "ok";
        return view('admin.products.specc-edit',compact('specss'));
    }
    public function updateProductSpec(Request $request)
    {
        $rule=[
            "spec_id"=>'required|exists:specs,id|integer',
            "product_id"=>'required|exists:products,id|integer',
            "value"=>'required|string',
        ];
        $request->validate($rule);
        $specs=Spec::find($request->spec_id);
        $specs->products()->updateExistingPivot($request->product_id,['value'=>$request->value]);
        return redirect('admin/product/show-product-spec/'.$request->product_id)->with('Success','The Spec has been updated successfully');
    }
    public function deleteSpecFromProduct( Request $request)
    {
        // return $request;
        $rules=[
            "product_id"=>"required|exists:products,id",
            "spec_id"=>"required|exists:specs,id"
        ];
        $request->validate($rules);
       $spec = Spec::find($request->spec_id)->products()->detach($request->product_id);
       return redirect()->back()->with('Success','Spec has been removed from this Product');
    }

}
