<?php

namespace App\Http\Controllers\Front\SinglePage;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SinglePageController extends Controller
{
    public function getProoductSinglePage($id){
        // return $id;
        $product=Product::leftjoin('offer_product','offer_product.product_id','=','products.id')
                ->join('subcategories','products.subCategory_id','=','subcategories.id')
                ->join('categories','subcategories.category_id','=','categories.id')
                ->join('brands','products.brand_id','=','brands.id')
                ->join('suppliers','products.supplier_id','=','suppliers.id')
                ->leftjoin('offers','offer_product.offer_id','=','offers.id')
                ->join('ratings', 'ratings.product_id','=','products.id')
                ->leftjoin('users','users.id','=','ratings.user_id')
                ->select('products.id as products_id',
                    'categories.name_en as product_category',
                    'subcategories.name_en as product_subcategory',
                    'brands.name_en as product_brand',
                    'categories.id as product_category_id',
                    'subcategories.id as product_subcategory_id',
                    'brands.id as product_brand_id',
                    'products.photo as product_photo',
                    'products.*',
                    'products.details_en as product_details_en',
                    'products.details_ar as product_details_ar','offers.*',
                    'users.name as user_name','suppliers.name_en as supplier_name',
                    DB::raw('products.price *((100-offers.discount)/100) AS price_after_discount'),
                    DB::raw('count(`ratings`.`user_id`) as user_rating_count'),'ratings.updated_at as rating_updated_at',
                    DB::raw('avg(`ratings`.`value`) as rating_average'),)
                // ->groupBy('ratings.product_id')
                ->orderBy('products.id', 'asc')
                ->where('products.id','=',$id)
                ->first();
                // return $product;
        $supplier_product=Product::where('supplier_id','=',$product->supplier_id)
        ->leftjoin('offer_product','offer_product.product_id','=','products.id')
        ->leftjoin('offers','offer_product.offer_id','=','offers.id')
        ->select('products.id as products_id',
            'offers.discount as offer_discount',
        'products.photo as product_photo',
        'products.*',
        )
        ->get();

        // foreach($supplier_product as $i){
        //     echo $i->offer_discount . "<br>";
        // }
        // return "sd";
        // return $supplier_product;
        // return $supplier_product;
        // return $product->supplier_id;
        $specs = Product::with('specs')->find($id);
        // return $specs->specs;
         $ratings_review=Product::find($id);
         $ratings= $ratings_review->userRate;
        //  return $product;
         $orders = [];
        if(Auth::user()){
         $orders = Order::with('products')->where('user_id','=', Auth::user()->id)->get();
        }
        // return $orders;
        return view('front.singlePage.product-single-page', compact('product','ratings','specs','orders','supplier_product'));
    }

    public function singlePageAddCart(Request $request){
        // return $request;
        $rules =[
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer'
        ];
        // validator
        $request->validate($rules);
        // return $request;
        $user = User::find($request->user_id);
        // return $user->product;
        $data=$request->only('quantity');
        // add record in pivot "cart"
        // return $data;
        // $user->product()->syncWithoutDetaching($data);
        // $user->product()->attach($request->product_id, $data);
        if (! $user->product->contains($request->product_id)) {
           $user->product()->attach($request->product_id, $data);
        }

        // $product->user()->attach($data);
        return redirect()->back()->with('Success', 'Added Successfully to Cart');
    }
}
