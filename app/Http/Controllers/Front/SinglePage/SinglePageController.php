<?php

namespace App\Http\Controllers\Front\SinglePage;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SinglePageController extends Controller
{
    public function getProoductSinglePage($id)
    {
        $product=Product::Join('offer_product','offer_product.product_id','=','products.id','left outer')
                ->join('offers','offer_product.offer_id','=','offers.id' ,'left outer')
                ->join('ratings', 'ratings.product_id','=','products.id', 'left outer')
                ->join('users','users.id','=','ratings.user_id', 'left outer')
                ->select('products.id as products_id',
                    'products.photo as product_photo',
                    'products.*',
                    'products.details_en as product_details_en',
                    'products.details_ar as product_details_ar','offers.*',
                    'ratings.*','users.name as user_name',
                    DB::raw('products.price *((100-offers.discount)/100) AS price_after_discount'),
                    DB::raw('count(*) as user_rating_count'),
                    DB::raw("COUNT(ratings.user_id) as count_click"))
                ->groupBy('products.id')
                ->orderBy('products.id', 'asc')
                ->where('products.id','=',$id)
                ->first();
        // return $product;
        return view('front.singlePage.product-single-page', compact('product'));
    }
}
