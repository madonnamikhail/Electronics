<?php

namespace App\Http\Controllers\offer;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Promocode;
use App\Models\Subcategory;
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
            "title_en"=>'string|max:100',
            "title_ar"=>'string|max:100',
            "discount"=>'string|max:10',
            "details_en"=>'string|max:100',
            "details_ar"=>'string|max:100',
            "photo"=>'image|mimes:png,jpg,jepg|max:1024',

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
        //  $products=Product::select('id','name_en','name_ar','photo','price','code', 'details_en','details_ar','offer_id','supplier_id','brand_id','subCategory_id')->where('offer_id','=',$id)->get();
        $allproducts=Product::get();
        $alloffers=Offer::get();
        $i=1;
        foreach($products  as $product){
            if($product->offer_id == ''){
                $offer[$i]='no offers';
            }
            else{
                $offer[$i]=Offer::select('title_en','title_ar')->find($product->offer_id);
            }
            $brand[$i]=Brand::select('name_en','name_ar')->find($product->brand_id);
            $SubCategory[$i]=Subcategory::select('name_en','name_ar')->find($product->subCategory_id );
            $i++;
        }
        // return $offer;
        return view('admin.products.offer-products',compact('products','allproducts','alloffers','offer','brand','SubCategory'));
    }
    public function addProductstoOffer(Request $request)
    {
        // return $request;
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
