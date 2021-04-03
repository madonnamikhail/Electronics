<?php

namespace App\Http\Controllers\offer;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Promocode;
use App\Models\Subcategory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\traits\generalTrait;

class OfferController extends Controller
{
    //
    use generalTrait;
    public function alloffers(){
        $offers=Offer::get();
        return view('admin.offer.all-offers',compact('offers'));
    }

    public function create(){
        return view('admin.offer.create-offer');
    }

    public function store(Request $request){
        // return $request;
        $rules=[
            "title_en"=>'required|string|max:100|unique:offers,title_en',
            "title_ar"=>'required|string|max:100|unique:offers,title_ar',
            "discount"=>"numeric|digits:2|required|unique:offers,discount",
            "details_en"=>'required|string',
            "details_ar"=>'required|string',
            "start_date"=>"required",
            "expire_date"=>"required",
            "photo"=>'mimes:png,jpg,jpeg|max:1024',
        ];
        $request->validate($rules);

        $imageName= $this->UploadPhoto($request->photo , 'offers');
        $data=$request->except('photo','_token');
        $data['photo']=$imageName;
        Offer::insert($data);
        return redirect('admin/offer/all-offers');
    }

    public function edit($id){
        //make sure that this id is exist if not return this item is not found
        $offers=Offer::find($id);
        return view('admin.offer.edit-offer' ,compact('offers'));
    }

    public function update(Request $request , $id){
        $rules=[
            "title_en"=>'required|string|max:100',
            "title_ar"=>'required|string|max:100',
            "discount"=>'required|string|max:10',
            "details_en"=>'required|string|max:100',
            "details_ar"=>'required|string|max:100',
            "photo"=>'mimes:png,jpg,jepg|max:1024',
        ];
        $request->validate($rules);
        $data=$request->except('_token','_method');
        if($request->has('photo')){
            $imageName= $this->UploadPhoto($request->photo , 'offers');
            $data=$request->except('photo','_token','_method');
            $data['photo']=$imageName;
        }
        $update=Offer::where('id','=', $id)->update($data);
        if($update){
            return redirect('admin/offer/all-offers');
        }
        return redirect()->back()->with('Error','failed ');
    }
#################################################Trying#######################################################################3
    public function showOffersProduct($id){

        $offers=Offer::find($id);
        $products= $offers->products;
        //to get offer id fro delete from pivot
        $offer_id=$id;
        //  $products=Product::select('id','name_en','name_ar','photo','price','code', 'details_en','details_ar','offer_id','supplier_id','brand_id','subCategory_id')->where('offer_id','=',$id)->get();
        $allproducts=Product::get();
        $alloffers=Offer::get();
        $brand=Brand::get();
        $subcategorys=Subcategory::get();
        $suppliers=Supplier::get();
        return view('admin.products.offer-products',compact('products','allproducts','alloffers','brand','subcategorys','suppliers','offer_id'));
    }
    public function addProductstoOffer(Request $request)
    {
        // return $request;
        $rules=[
            "products.*"=>"required|numeric|exists:products,id",
            "offers"=>"required|numeric|exists:offers,id"
        ];
        $request->validate($rules);
        $offer=Offer::find($request->offers);
        if(!$offer)
            return abort('404');
        $offer->products()->syncWithoutDetaching($request->products);
        // $data['offer_id']=[$request->offers];
        // $update=Product::where('id','=', $request->products)->update($data);
        // $product=Product::find($request->products);
        // $product ->offer_id=$request->offers;
        // $product->save();
        // return $product;
        return redirect('admin/offer/show-offers-product/'.$offer->id);
    }

    public function deleteProductFromOffer(Request $request)
    {

        // return $request;
        // $rule=[
        //     "id"=>'required|exists:products,id|integer'
        // ];
        // $request->validate($rule);
        // $photoPath=public_path("images\product\\" . $request->photo);
        // // return $photoPath;
        // if(file_exists($photoPath)){
        //    unlink($photoPath);
        // }
        // Product::destroy($request->id);
        // return redirect('admin/product/show-all');


        $product_id = $request->id;
        $offer = Offer::find($request->offer_id)->products()->detach($product_id);
        return redirect()->back()->with('Success','Product has been removed from this offer');
    }















    public function delete(Request $request){
        // return $request;
        $rule=[
            "id"=>'required|exists:offers,id|integer'
        ];
        $request->validate($rule);
        $photoPath=public_path("images\offers\\" . $request->photo);
        // return $photoPath;
        if(file_exists($photoPath)){
           unlink($photoPath);
        }
        Offer::destroy($request->id);
        return redirect('admin/offer/all-offers');
    }
}
