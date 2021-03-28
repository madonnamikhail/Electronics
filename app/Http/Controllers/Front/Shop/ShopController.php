<?php

namespace App\Http\Controllers\Front\Shop;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RecursiveDirectoryIterator;

class ShopController extends Controller
{
    public function getShop() {
        $products = Product::Join('offer_product', 'offer_product.product_id', '=', 'products.id', 'left outer')
            ->join('offers', 'offer_product.offer_id', '=', 'offers.id', 'left outer')
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
            ->limit(6)->get();

        $categories = Category::get();
        $brands=Brand::get();
        $subCategories=Subcategory::get();

        $cats = [];$subs = [] ; $brand_ids = [] ;
        // return $products;
        return view('front.shop.shop-page', compact('products', 'categories','brands','subCategories','cats','subs','brand_ids'));
    }
    public function get_causes_against_category($id) {
        $id = explode(',', $id);
        $products = Subcategory::whereIn('category_id', $id)
            ->join('products', 'products.subCategory_id', '=', 'subcategories.id')
            ->Join('offer_product', 'offer_product.product_id', '=', 'products.id', 'left outer')
            ->join('offers', 'offer_product.offer_id', '=', 'offers.id', 'left outer')
            ->select('products.id as products_id', 'products.photo as product_photo', 'products.*', 'offers.*', DB::raw('products.price *((100-offers.discount)/100) AS price_after_discount'))
            ->orderBy('products.id', 'asc')
            ->get();
        $total_row = count($products);
        // return $total_row;

        $output = '';
        if ($total_row > 0) {
            foreach ($products as $product) {
                $directory = 'http://127.0.0.1:8000/images/product/' . $product->product_photo;
                $token = csrf_token();
                $output .= '
                    <div class="product-wrapper col-lg-4">
                    <div class="product-img">
                        <a href="route(\'get-product-single-page\',' . $product->products_id . ')">
                            <img alt="" src="' . $directory . '">
                        </a>';
                if ($product->discount) {
                    $output .= '<span>' . $product->discount . '%</span>';
                }
                $output .= '<div class="product-action">
                            <a class="action-wishlist" href="#" title="Wishlist">
                                <i class="ion-android-favorite-outline"></i>
                            </a>
                            <a class="action-cart" href="#" title="Add To Cart">
                                <i class="ion-ios-shuffle-strong"></i>
                            </a>
                            <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                <i class="ion-ios-search-strong"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-content text-left">
                        <div class="product-hover-style">
                            <div class="product-title">
                                <h4>
                                    <a href="#">' . $product->name_en . '</a>
                                </h4>
                            </div>
                            <div class="cart-hover">
                                <form action="' . route('add.to.cart') . '" method="post">
                                <input type="hidden" name="_token" id="csrf-token" value="' . $token . '" />
                                    <input type="hidden" name="user_id" value="' . Auth::user()->id . '">
                                    <input type="hidden" name="product_id" value="' . $product->products_id . '">
                                    <button type="submit">
                                        <a class="action-cart" title="Add To Cart">
                                            + Add to cart
                                            <i class="ion-ios-shuffle-strong"></i>
                                        </a>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="product-price-wrapper">
                        ';
                if ($product->discount) {
                    $output .= '<span>EGP ' . $product->price_after_discount . ' -</span>
                                <span class="product-price-old">EGP ' . $product->price . ' </span>';
                } else {
                    $output .= '<span >EGP ' . $product->price . '</span>';
                }

                $output .= '</div>
                                </div>
                            </div>
                        ';
            }
        } else {
            $output = '<h3>No Data Found</h3>';
        }
        return response()->json($output);
    }
    public function loadMore(Request $request){
        $products = Product::Join('offer_product', 'offer_product.product_id', '=', 'products.id', 'left outer')
            ->join('offers', 'offer_product.offer_id', '=', 'offers.id', 'left outer')
            ->select(
                'products.id as product_id',
                'products.photo as product_photo',
                'products.*',
                'products.details_en as product_details_en',
                'products.details_ar as product_details_ar',
                'offers.*',
                DB::raw('products.price *((100-offers.discount)/100) AS price_after_discount')
            )
            ->where('products.id', '>', $request->id)
            ->orderBy('products.id', 'asc')
            ->take(6)->get();
        $output = "";
        foreach ($products as $product) {
            $directory = 'http://127.0.0.1:8000/images/product/' . $product->product_photo;
            $token = csrf_token();
            $output .= "
            <div class='product-width col-xl-4 col-lg-12 col-md-4 col-sm-6 col-12 mb-30'>
            <div class='product-wrapper col-lg-4'>
                <div class='product-img'>
                    <a href='".route('get-product-single-page', $product->product_id) . "'>

                    </a>";

            if ($product->discount) {
                $output .= "<span>" . $product->discount . "%</span>";
            }
            $output .= "
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
                                </h4><a href='#'>" . $product->name_en . "</a>
                            </h4>
                        </div>
                        <div class='cart-hover'>
                            <form action='{{ route('add.to.cart') }}' method='post'>
                                @csrf
                                <input type='hidden' name='user_id' value='{{ Auth::user()->id }}'>
                                <input type='hidden' name='product_id' value='" . $product->products_id . "'>
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
            if ($product->discount) {
                $output .= "<span>EGP " . $product->price_after_discount . " -</span>
                            <span class='product-price-old'>EGP " . $product->price . " </span>";
            } else {
                $output .= "<span >EGP " . $product->price . " </span>";
            }
            $output .= "
                    </div>
                </div>
                <div class='product-list-details'>
                    <h4>
                        <a href='#'>" . $product->name_en . "</a>
                    </h4>
                    <div class='product-price-wrapper'>";
            if ($product->discount) {
                $output .= "<span>EGP " . $product->price_after_discount . " -</span>
                            <span class='product-price-old'>EGP " . $product->price . " </span>";
            } else {
                $output .= "<span >EGP " . $product->price . " </span>";
            }
            $output .= "
                    </div>
                    <p>" . $product->product_details_en . "</p>
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
        }

        $output .= '
        <div class="pagination-total-pages" id="remove_row">
                <button class="alert alert-success ml-auto mr-auto w-100 h-100vh"
                style="outline: none; border:none" id="load_more"
                data-id=' . $id . ' type="button" onclick="loadingMore()">Load More</button>
        </div>
        ';
        return $output;
    }
    public function priceFilter(Request $request) {
        // return $request->minimum_price .".". $request->maximum_price;
        $products = Product::Join('offer_product', 'offer_product.product_id', '=', 'products.id', 'left outer')
            ->join('offers', 'offer_product.offer_id', '=', 'offers.id', 'left outer')
            ->select('products.id as products_id', 'products.photo as product_photo', 'products.*','products.price as products_price', 'offers.*', DB::raw('products.price *((100-offers.discount)/100) AS price_after_discount'))
            ->orderBy('products.id', 'asc')
            // ->where('price', '>=', $request->minimum_price)->where('price', '<=', $request->maximum_price)
            // ->where('price', '<=', $request->minimum_price)->where('price', '<=', $request->maximum_price)
            // ->whereBetween('price', [$request->minimum_price, $request->maximum_price])
            ->whereRaw('price BETWEEN ' . $request->minimum_price . ' AND ' . $request->maximum_price . '')
            ->get();
            // min<=price<=max
            // agefrom  <= age<=   ageto

        $total_row = count($products);
        return $total_row;
        $output = '';
        if ($total_row > 0) {
            foreach ($products as $product) {
                $directory = 'http://127.0.0.1:8000/images/product/' . $product->product_photo;
                $token = csrf_token();
                $output .= '
                                <div class="product-wrapper col-lg-4">
                                <div class="product-img">
                                    <a href="route(\'get-product-single-page\',' . $product->products_id . ')">
                                        <img alt="" src="' . $directory . '">
                                    </a>';
                if ($product->discount) {
                    $output .= '<span>' . $product->discount . '%</span>';
                }
                $output .= '<div class="product-action">
                                        <a class="action-wishlist" href="#" title="Wishlist">
                                            <i class="ion-android-favorite-outline"></i>
                                        </a>
                                        <a class="action-cart" href="#" title="Add To Cart">
                                            <i class="ion-ios-shuffle-strong"></i>
                                        </a>
                                        <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                            <i class="ion-ios-search-strong"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-content text-left">
                                    <div class="product-hover-style">
                                        <div class="product-title">
                                            <h4>
                                                <a href="#">' . $product->name_en . '</a>
                                            </h4>
                                        </div>
                                        <div class="cart-hover">
                                            <form action="' . route('add.to.cart') . '" method="post">
                                            <input type="hidden" name="_token" id="csrf-token" value="' . $token . '" />
                                                <input type="hidden" name="user_id" value="' . Auth::user()->id . '">
                                                <input type="hidden" name="product_id" value="' . $product->products_id . '">
                                                <button type="submit">
                                                    <a class="action-cart" title="Add To Cart">
                                                        + Add to cart
                                                        <i class="ion-ios-shuffle-strong"></i>
                                                    </a>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="product-price-wrapper">
                                    ';
                if ($product->discount) {
                    $output .= '<span>EGP ' . $product->price_after_discount . ' -</span>
                                                <span class="product-price-old">EGP ' . $product->price . ' </span>';
                } else {
                    $output .= '<span >EGP ' . $product->price . '</span>';
                }

                $output .= '</div>
                                </div>
                            </div>
                        ';
            }
        } else {
            $output = '<h3>No Data Found</h3>';
        }
        // return response()->json($output);
        return $output;
    }
    public function getbrand($id){
        // return $id;
        var_dump($id);die;
        $id = explode(',', $id);
        var_dump($id);die;
        $products = Product::whereIn('brand_id',$id)
        ->Join('offer_product', 'offer_product.product_id', '=', 'products.id', 'left outer')
        ->join('offers', 'offer_product.offer_id', '=', 'offers.id', 'left outer')
        ->select('products.id as products_id', 'products.photo as product_photo', 'products.*', 'offers.*', DB::raw('products.price *((100-offers.discount)/100) AS price_after_discount'))
        ->orderBy('products.id', 'asc')
        ->get();
        $total_row = count($products);
        $output = '';
        if ($total_row > 0) {
            foreach ($products as $product) {
                $directory = 'http://127.0.0.1:8000/images/product/' . $product->product_photo;
                $token = csrf_token();
                $output .= '
                    <div class="product-wrapper col-lg-4">
                    <div class="product-img">
                        <a href="route(\'get-product-single-page\',' . $product->products_id . ')">
                            <img alt="" src="' . $directory . '">
                        </a>';
                if ($product->discount) {
                    $output .= '<span>' . $product->discount . '%</span>';
                }
                $output .= '<div class="product-action">
                            <a class="action-wishlist" href="#" title="Wishlist">
                                <i class="ion-android-favorite-outline"></i>
                            </a>
                            <a class="action-cart" href="#" title="Add To Cart">
                                <i class="ion-ios-shuffle-strong"></i>
                            </a>
                            <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                <i class="ion-ios-search-strong"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-content text-left">
                        <div class="product-hover-style">
                            <div class="product-title">
                                <h4>
                                    <a href="#">' . $product->name_en . '</a>
                                </h4>
                            </div>
                            <div class="cart-hover">
                                <form action="' . route('add.to.cart') . '" method="post">
                                <input type="hidden" name="_token" id="csrf-token" value="' . $token . '" />
                                    <input type="hidden" name="user_id" value="' . Auth::user()->id . '">
                                    <input type="hidden" name="product_id" value="' . $product->products_id . '">
                                    <button type="submit">
                                        <a class="action-cart" title="Add To Cart">
                                            + Add to cart
                                            <i class="ion-ios-shuffle-strong"></i>
                                        </a>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="product-price-wrapper">
                        ';
                if ($product->discount) {
                    $output .= '<span>EGP ' . $product->price_after_discount . ' -</span>
                                <span class="product-price-old">EGP ' . $product->price . ' </span>';
                } else {
                    $output .= '<span >EGP ' . $product->price . '</span>';
                }

                $output .= '</div>
                                </div>
                            </div>
                        ';
            }
        } else {
            $output = '<h3>No Data Found</h3>';
        }
        return response()->json($output);
    }
    public function getSubcategory($id){
        $id = explode(',', $id);
        // return $id;
        $products = Product::whereIn('subCategory_id',$id)
        ->Join('offer_product', 'offer_product.product_id', '=', 'products.id', 'left outer')
        ->join('offers', 'offer_product.offer_id', '=', 'offers.id', 'left outer')
        ->select('products.id as products_id', 'products.photo as product_photo', 'products.*', 'offers.*',
        DB::raw('products.price *((100-offers.discount)/100) AS price_after_discount'))
        ->orderBy('products.id', 'asc')
        ->get();
        $total_row = count($products);
        // return $total_row;
        $output = '';
        if ($total_row > 0) {
            foreach ($products as $product) {
                $directory = 'http://127.0.0.1:8000/images/product/' . $product->product_photo;
                $token = csrf_token();
                $output .= '
                    <div class="product-wrapper col-lg-4">
                    <div class="product-img">
                        <a href="route(\'get-product-single-page\',' . $product->products_id . ')">
                            <img alt="" src="' . $directory . '">
                        </a>';
                if ($product->discount) {
                    $output .= '<span>' . $product->discount . '%</span>';
                }
                $output .= '<div class="product-action">
                            <a class="action-wishlist" href="#" title="Wishlist">
                                <i class="ion-android-favorite-outline"></i>
                            </a>
                            <a class="action-cart" href="#" title="Add To Cart">
                                <i class="ion-ios-shuffle-strong"></i>
                            </a>
                            <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                <i class="ion-ios-search-strong"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-content text-left">
                        <div class="product-hover-style">
                            <div class="product-title">
                                <h4>
                                    <a href="#">' . $product->name_en . '</a>
                                </h4>
                            </div>
                            <div class="cart-hover">
                                <form action="' . route('add.to.cart') . '" method="post">
                                <input type="hidden" name="_token" id="csrf-token" value="' . $token . '" />
                                    <input type="hidden" name="user_id" value="' . Auth::user()->id . '">
                                    <input type="hidden" name="product_id" value="' . $product->products_id . '">
                                    <button type="submit">
                                        <a class="action-cart" title="Add To Cart">
                                            + Add to cart
                                            <i class="ion-ios-shuffle-strong"></i>
                                        </a>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="product-price-wrapper">
                        ';
                if ($product->discount) {
                    $output .= '<span>EGP ' . $product->price_after_discount . ' -</span>
                                <span class="product-price-old">EGP ' . $product->price . ' </span>';
                } else {
                    $output .= '<span >EGP ' . $product->price . '</span>';
                }

                $output .= '</div>
                                </div>
                            </div>
                        ';
            }
        } else {
            $output = '<h3>No Data Found</h3>';
        }
        return response()->json($output);
    }

    // multi filter
    public function filtering(Request $request)
    {
        $cats = [];$subs = [] ; $brand_ids = [] ;
         
        $query = Product::select('products.*');
        if($request->has('cats')){
            $cat_ids = $request->cats;
            $cat_ids = array_map('intval', $cat_ids);
            $cat_ids =implode(",", $cat_ids);
            $cat_ids = str_replace(',','',$cat_ids);
            $cat_ids = str_split($cat_ids);
            $cats = $cat_ids;
            // return Product::whereIn('id',$ids)->get();
            $query = Subcategory::whereIn('category_id', $cat_ids)
                        ->join('products', 'products.subCategory_id', '=', 'subcategories.id');
        }
        if($request->has('subs')){
            $sub_ids = $request->subs;
            $sub_ids = array_map('intval', $sub_ids);
            $sub_ids =implode(",", $sub_ids);
            $sub_ids = str_replace(',','',$sub_ids);
            $sub_ids = str_split($sub_ids);
            $subs = $sub_ids ;
            // return Product::whereIn('id',$ids)->get();
            $query = $query->whereIn('subCategory_id', $sub_ids);
        }
        if($request->has('brands')){
            $brand_ids = $request->brands;
            $brand_ids = array_map('intval', $brand_ids);
            $brand_ids =implode(",", $brand_ids);
            $brand_ids = str_replace(',','',$brand_ids);
            $brand_ids = str_split($brand_ids);
            $brand_ids = $brand_ids ;
            // return Product::whereIn('id',$ids)->get();
            $query = $query->whereIn('brand_id', $brand_ids);
        }
        $query = $query->Join('offer_product', 'offer_product.product_id', '=', 'products.id', 'left outer')
        ->join('offers', 'offer_product.offer_id', '=', 'offers.id', 'left outer')
        ->select('products.id as product_id', 'products.photo as product_photo', 'products.*', 'offers.*',
        DB::raw('products.price *((100-offers.discount)/100) AS price_after_discount'))
        ->orderBy('products.id', 'asc')
        // ->toSql();
        // return $query;
        ->get();
        $total_row = count($query);
        // return $total_row;
        $output = '';
        if ($total_row > 0) {
            foreach ($query as $product) {
                $directory = 'http://127.0.0.1:8000/images/product/' . $product->product_photo;
                $token = csrf_token();
                $output .= '
                    <div class="product-wrapper col-lg-4">
                    <div class="product-img">
                        <a href="route(\'get-product-single-page\',' . $product->products_id . ')">
                            <img alt="" src="' . $directory . '">
                        </a>';
                if ($product->discount) {
                    $output .= '<span>' . $product->discount . '%</span>';
                }
                $output .= '<div class="product-action">
                            <a class="action-wishlist" href="#" title="Wishlist">
                                <i class="ion-android-favorite-outline"></i>
                            </a>
                            <a class="action-cart" href="#" title="Add To Cart">
                                <i class="ion-ios-shuffle-strong"></i>
                            </a>
                            <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                <i class="ion-ios-search-strong"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-content text-left">
                        <div class="product-hover-style">
                            <div class="product-title">
                                <h4>
                                    <a href="#">' . $product->name_en . '</a>
                                </h4>
                            </div>
                            <div class="cart-hover">
                                <form action="' . route('add.to.cart') . '" method="post">
                                <input type="hidden" name="_token" id="csrf-token" value="' . $token . '" />
                                    <input type="hidden" name="user_id" value="' . Auth::user()->id . '">
                                    <input type="hidden" name="product_id" value="' . $product->products_id . '">
                                    <button type="submit">
                                        <a class="action-cart" title="Add To Cart">
                                            + Add to cart
                                            <i class="ion-ios-shuffle-strong"></i>
                                        </a>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="product-price-wrapper">
                        ';
                if ($product->discount) {
                    $output .= '<span>EGP ' . $product->price_after_discount . ' -</span>
                                <span class="product-price-old">EGP ' . $product->price . ' </span>';
                } else {
                    $output .= '<span >EGP ' . $product->price . '</span>';
                }

                $output .= '</div>
                                </div>
                            </div>
                        ';
            }
        } else {
            $output = '<h3>No Data Found</h3>';
        }
        // echo $output;die;
        $products = $query;
        

        // return response()->json(array('output','cats','subs','brands'));
        $categories = Category::get();
        $brands=Brand::get();
        $subCategories=Subcategory::get();

        $catego = Category::select('categories.id')->get();
        $t =(array)[];
        foreach ($catego->toArray() as $key => $value) {
            foreach($value as $k => $v){
                array_push($t, $v);
           }
        }
        
        $idd = $t;
        // $c = [1,2];
        // $diffs = array_diff($idd, $c);
        // return $diff_values = array_values($diffs);
        return view('front.shop.shop-page', compact('products', 'categories','brands','subCategories','cats','subs','brand_ids','idd'));


    }
}
