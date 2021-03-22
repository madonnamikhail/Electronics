<?php

namespace App\Http\Controllers\Front\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function getShop()
    {
        $products=Product::Join('offer_product','offer_product.product_id','=','products.id','left outer')
                    ->join('offers','offer_product.offer_id','=','offers.id' ,'left outer')
                    ->select('products.id as product_id','products.photo as product_photo','products.*',
                    'products.details_en as product_details_en','products.details_ar as product_details_ar','offers.*',DB::raw('products.price *((100-offers.discount)/100) AS price_after_discount'))
                    ->orderBy('products.id', 'asc')
                    ->limit(6)->get();

        $categories = Category::get();

        // return $products;
        return view('front.shop.shop-page', compact('products','categories'));
    }

    public function get_causes_against_category($id){

        $data = Subcategory::where('category_id','=',$id)
                ->join('products','products.subCategory_id','=','subcategories.id' ,'left outer')
                ->get();

       echo json_encode($data);
   }

    public function loadMore(Request $request)
    {
        $products=Product::Join('offer_product','offer_product.product_id','=','products.id','left outer')
                    ->join('offers','offer_product.offer_id','=','offers.id' ,'left outer')
                    ->select('products.id as product_id','products.photo as product_photo','products.*',
                    'products.details_en as product_details_en','products.details_ar as product_details_ar','offers.*',
                    DB::raw('products.price *((100-offers.discount)/100) AS price_after_discount'))
                    ->where('products.id','>',$request->id)
                    ->orderBy('products.id', 'asc')
                    ->take(6)->get();
        // return response()->json($data);
        // return $products;
        // <img alt='' src='{{ asset('images\product\\'. $product->product_photo ) }}'>
        $output = "";
        foreach($products as $product){
            $output .= "
            <div class='product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30'>
            <div class='product-wrapper'>
                <div class='product-img'>
                    <a href='product-details.html'>

                    </a>";

                    if($product->discount ){
                        $output .= "<span>{{$product->discount}}%</span>";
                    }
                    $output .="
                    <div class='product-action'>
                        <a class='action-wishlist' href='#' title='Wishlist'>
                            <i class='ion-android-favorite-outline'></i>
                        </a>
                        <a class='action-cart' href='#' title='Add To Cart'>
                            <i class='ion-ios-shuffle-strong'></i>
                        </a>
                        <a class='action-compare' href='#' data-target='#exampleModal' data-toggle='modal' title='Quick View'>
                            <i class='ion-ios-search-strong'></i>
                        </a>
                    </div>
                </div>
                <div class='product-content text-left'>
                    <div class='product-hover-style'>
                        <div class='product-title'>
                            <h4>
                                </h4><a href='#'>{{ $product->name_en }}</a>
                            </h4>
                        </div>
                        <div class='cart-hover'>
                            <form action='{{ route('add.to.cart') }}' method='post'>
                                @csrf
                                <input type='hidden' name='user_id' value='{{ Auth::user()->id }}'>
                                <input type='hidden' name='product_id' value='{{ $product->products_id }}'>
                                <button type='submit'>
                                    <a class='action-cart' title='Add To Cart'>
                                        + Add to cart
                                        <i class='ion-ios-shuffle-strong'></i>
                                    </a>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class='product-price-wrapper'>";
                        if($product->discount ){
                            $output .= "<span>EGP {{ $product->price_after_discount }} -</span>
                            <span class='product-price-old'>EGP {{ $product->price}} </span>";
                        }else{
                            $output .= "<span >EGP {{ $product->price}} </span>";
                        }
                    $output .="
                    </div>
                </div>
                <div class='product-list-details'>
                    <h4>
                        <a href='#'>{{ $product->name_en }}</a>
                    </h4>
                    <div class='product-price-wrapper'>";
                        if($product->discount ){
                            $output .= "<span>EGP {{ $product->price_after_discount }} -</span>
                            <span class='product-price-old'>EGP {{ $product->price}} </span>";
                        }else{
                            $output .= "<span >EGP {{ $product->price}} </span>";
                        }
                        $output .="
                    </div>
                    <p>{{ $product->product_details_en }}</p>
                    <div class='shop-list-cart-wishlist'>
                        <a href='#' title='Wishlist'><i class='ion-android-favorite-outline'></i></a>
                        <a href='#' title='Add To Cart'><i class='ion-ios-shuffle-strong'></i></a>
                        <a href='#' data-target='#exampleModal' data-toggle='modal' title='Quick View'>
                            <i class='ion-ios-search-strong'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
            ";

            $id = $product->product_id;
        // return $product->discount;
        }

        $output .= "
        <div class='pagination-total-pages' id='remove_row'>
                <button type='submit' class='alert alert-success ml-auto mr-auto w-100 h-100vh' style='outline: none; border:none id='load_more' data-id='{{ $id }}'>Load More</button>
        </div>
        ";
        // echo $output;
        return response()->json($output);
    }
}
