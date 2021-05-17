<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Region;
use App\Models\Subcategory;
use App\User;
use Facade\Ignition\Middleware\AddLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NunoMaduro\Collision\Adapters\Phpunit\Printer;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function searchBox(Request $request){
        // return $request->all();
        $search_data= $request->searchText;
        // $products=Product::where('id', '=', '1')->get();
        $products=Product::where('name_en', 'LIKE', '%'.$search_data.'%')->get();

        // return $products;
        // return count($products);
        if(count($products)>0){
            foreach($products as $product){
                echo "<a href ='".route('get-product-single-page',$product->id)."' class='list-group-item list-group-item-action border-1' id='product_search'>".$product->name_en."</a>";
            }
        }else
        {
            echo "<p class='list-group-item border-1'>No Records</p>";
        }
    }
    public function searchBoxbutton(Request $request){
        $products=Product::where('name_en', 'LIKE', '%'.$request->search.'%')
        // ->Join('offer_product', 'offer_product.product_id', '=', 'products.id', 'left outer')
        // ->join('offers', 'offer_product.offer_id', '=', 'offers.id', 'left outer')
        ->leftJoin('offer_product', 'offer_product.product_id', '=', 'products.id')
        ->leftJoin('offers', 'offer_product.offer_id', '=', 'offers.id'/*, 'left outer'*/)
        ->select(
            'products.id as product_id',
            'products.photo as product_photo',
            'products.*',
            'products.details_en as product_details_en',
            'products.details_ar as product_details_ar',
            'offers.*',
            DB::raw('products.price *((100-offers.discount)/100) AS price_after_discount')
        )
        ->orderBy('products.id', 'asc')
        ->get();
        $categories = Category::get();
        $brands=Brand::get();
        $subCategories=Subcategory::get();
        $id=0;
        $cats = [];$subs = [] ; $brand_ids = [] ;
        $idd = [];
        $brand_idd=[];
        $subcategory_idd=[];
        $min=0;
        $max=6500000;
        // return $products;
        return view('front.shop.shop-page',compact('products', 'categories','brands','subCategories','cats','subs','brand_ids','idd','brand_idd','subcategory_idd','min','max','id'));
    }
    public function index(){
        $products=Product::leftJoin('offer_product', 'offer_product.product_id', '=', 'products.id')
                     ->leftJoin('offers', 'offer_product.offer_id', '=', 'offers.id'/*, 'left outer'*/)
                    //     Join('offer_product','offer_product.product_id','=','products.id','left outer')
                    // ->join('offers','offer_product.offer_id','=','offers.id' ,'left outer')
                    ->select('products.id as products_id','products.photo as product_photo','products.*',
                    'offers.*',DB::raw('products.price *((100-offers.discount)/100) AS price_after_discount'))
                    ->orderBy('products.id', 'asc')
                    ->take(5)->get();
        // return $products;
        //newest products
        $newest_products=Product::with('offers')->orderBy('id', 'desc')->limit(4)->get();

        //Hot Deals(50% & 70% only from offers)
        $offers = Offer::get();
        $brands=Brand::orderBy('id','ASC')->get();
        $categories=Category::get();
        // return $categories;
    return view('front.userindex', compact('products','brands','offers','newest_products','categories'));
    }
    public function addCart(Request $request) {
        $rules =[
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ];
        // validator
        $request->validate($rules);
        $user = User::find($request->user_id);
        $data=$request->except('_token');
        // add record in pivot "cart"
        // $user->product()->syncWithoutDetaching($data);
        $user->product()->syncWithoutDetaching($request->product_id, $data);
        // $product->user()->attach($data);
        return redirect()->back()->with('Success', 'Added Successfully to Cart');
    }

    public function getCart()
    {
        // get l carts
        $user_id = Auth::user()->id;
        $regions = Region::get();
        $cities = City::get();
        $addresses = Address::where('user_id', '=', $user_id)->get();
        // return $addresses;
        $user = User::find($user_id);
        $products=Product::leftJoin('offer_product', 'offer_product.product_id', '=', 'products.id')
        ->leftJoin('offers', 'offer_product.offer_id', '=', 'offers.id'/*, 'left outer'*/)
                    // Join('offer_product','offer_product.product_id','=','products.id','left outer')
                    // ->join('offers','offer_product.offer_id','=','offers.id' ,'left outer')
                    ->join('carts','carts.product_id','=','products.id')
                    ->select('carts.user_id as user_id','carts.quantity as quantity',
                        'products.id as product_id',
                        'products.photo as product_photo',
                        'products.*',
                        'offers.*',
                        DB::raw('products.price *((100-offers.discount)/100) AS price_after_discount'))
                    ->orderBy('products.id', 'asc')->get();
                    // return $products;
        return view('front.cart', compact('products','user_id','addresses','regions','cities'));
    }

    public function cartClear()
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id)->product()->detach();
        return redirect()->back()->with('Success', 'Your Cart Has Been Cleared');
    }

    public function cartProductEdit($product_id)
    {
        $product = Product::find($product_id);
        $quantities = $product->user;
        foreach ($quantities as $quantity) {
             $product_quantity =  $quantity->pivot->quantity;
        }
        return view('front.editCart', compact('product', 'product_quantity'));
    }

    public function cartProductUpdate(Request $request, $id)
    {
        $rules=[
            'product_quantity' => 'required|integer',
        ];
        $request->validate($rules);
        $user_id = Auth::user()->id;
        $one=Product::find($id)->user()->updateExistingPivot($user_id, ['quantity' => $request->product_quantity]);
        return redirect('/cart')->with('Success', 'Your Cart Has Been Updated');
    }

    public function cartProductDelete(Request $request)
    {
        $rules=[
            'product_id' => 'required|exists:products,id|integer',
        ];
        $request->validate($rules);
        $user_id = Auth::user()->id;
        $user = User::find($user_id)->product()->detach($request->product_id);
        // return $request;
        return redirect()->back()->with('Success', 'Your Cart Has Been Updated');
    }

    public function cartTotal(Request $request){
        // return $request;
        $rules=[
            'address_id'=>'exists:addresss,id|required',

        ];
        $request->validate($rules);

        $address_id=$request->address_id;
        $address=Address::where('id','=',$request->address_id)->first();
        $regions = Region::get();
        $cities = City::get();
        // return $address_id;
        $user_id = Auth::user()->id;
        $products=Product::leftJoin('offer_product', 'offer_product.product_id', '=', 'products.id')
        ->leftJoin('offers', 'offer_product.offer_id', '=', 'offers.id'/*, 'left outer'*/)
                    ->join('carts','carts.product_id','=','products.id')
                    ->select('carts.user_id as user_id','carts.quantity as quantity',
                        'products.id as product_id',
                        'products.photo as product_photo',
                        'products.*',
                        'offers.*',
                        DB::raw('IF(
                            offers.discount IS NULL,
                            1,
                            ((100 - offers.discount) / 100)
                        ) AS `discount`') ,
                        DB::raw('products.price * IF(
            offers.discount IS NULL,
            1,
            ((100 - offers.discount) / 100)
        ) AS `price_after_discount`'),
                        DB::raw('products.price * IF(
                            offers.discount IS NULL,
                            1,
                            ((100 - offers.discount) / 100)
                        ) * carts.quantity AS `total_price_after_discount`'))
                    ->orderBy('products.id', 'asc')->get();
            // return $products;
        return view('front.cart-total',compact('products','user_id','address','address_id','regions','cities'));
    }
    public function hotDeals($id)
    {
        //kda m3ana id al offer
        $offers=Offer::find($id);
        $products_offers=$offers->products;
        // return $products_offers;
        $discount_value=$offers->discount;
        return view('front.hot_deals',compact('products_offers','discount_value'));
    }

}
