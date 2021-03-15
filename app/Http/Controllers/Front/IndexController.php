<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
use Auth;
use NunoMaduro\Collision\Adapters\Phpunit\Printer;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        $products=Product::/*with('offers')->*/Join('offer_product','offer_product.product_id','=','products.id','left outer')
                    ->join('offers','offer_product.offer_id','=','offers.id' ,'left outer')
                    ->select('products.id as products_id','products.photo as product_photo','products.*','offers.*',DB::raw('products.price *((100-offers.discount)/100) AS price_after_discount'))
                    ->orderBy('products.id', 'asc')
                    ->take(5)->get();
        // return $products;

         //newest products
         $newest_products=Product::with('offers')->orderBy('id', 'desc')->limit(4)->get();
        //  return $newest_products->price;

        //Hot Deals(50% & 70% only from offers)
        $offers=Offer::get();
        $hot_deals=[];
        $sales=[];
        $j=0;
        $i=0;
        foreach($offers as $offer){
            $discount_value=(100-trim($offer->discount,"% , -"));
            //lma kona bntktbha $discount_value > 50 kan bygeb al 3aks
            if($discount_value == 50 || $discount_value < 50){
                $hot_deals[$i]=$offer;
                $i++;
            }
        }
        foreach($offers as $offer){
            $discount_value=(100-trim($offer->discount,"% , -"));
            //lma kona bntktbha $discount_value > 50 kan bygeb al 3aks
            if($discount_value > 50){
                $sales[$j]=$offer;
                $j++;
            }
        }


        // return $offerValues;
    return view('front.userindex', compact('products','hot_deals','sales','newest_products'/*,'categories'*/));
    }
    public function addCart(Request $request)
    {
        // user_id, product_id
        // fl pivot--carts
        // return $request;
        // rules
        // $product = Product::find(3);
        // return $product->user;
        $rules =[
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ];
        $product = Product::find($request->product_id);
        $user = User::find($request->user_id);
        // validator
        $request->validate($rules);
        $data=$request->except('_token');
        // add record in pivot "cart"
        // return $product;
        // $user->product()->syncWithoutDetaching($data);
        $user->product()->syncWithoutDetaching($request->product_id, $data);
        // $product->user()->attach($data);
        return redirect()->back()->with('Success', 'Added Successfully to Cart');
    }

    public function getCart()
    {
        // get l carts
        $user_id = Auth::user()->id;
        // return $user_id;
        $user = User::find($user_id);
        $products = $user->product;
        // return $products;
        $price=[];
        $i=0;
        foreach ($products as $product){
            $product_offers= $product->offers;
            // return $product_offers;
            if($product_offers && count($product_offers)>0 ){
                foreach($product_offers as $product_offer){
                    $offers=(100-trim($product_offer->discount,"% , -"))/(100);
                    $price[$i] = $product->price * $offers;
                    $i++;
                }
            }
            else{
                $price[$i] = $product->price;
                $i++;
            }
        }
        // return $price;
        // return $products;
        return view('front.cart', compact('products','price'));

    //     foreach($products as $product){
    //         $offerValues[$i]=$product->offers;

    //         if(empty($offerValues[$i])){
    //            echo "hena aho";
    //         }
    //        //  echo $offerValues[$i];
    //        $i++;
    //    }
    }

    public function cartClear()
    {
        $user_id = Auth::user()->id;
        // return $user_id;
        // $user = User::find($user_id);
        // $products_cart = $user->product;
        // return "ok";
        // return $products_cart;
        // foreach($products_cart as $product_cart){
        //     $user->product()->detach($product_cart->pivot->product_id);
        // }
        // ReportMessages::find(1)->reports()->where('report_id',$report_id)->delete();
        $user = User::find($user_id)->product()->detach();
        // $user->product()->detach();
        // $user->delete
        return redirect()->back()->with('Success', 'Your Cart Has Been Cleared');
    }

    public function cartProductEdit($product_id)
    {
        $product = Product::find($product_id);
        $quantities = $product->user;
        foreach ($quantities as $quantity) {
             $product_quantity =  $quantity->pivot->quantity;
        }

        // return $product_quantity;
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

    public function cartTotal(){
        // $products=
        $user_id = Auth::user()->id;
        // return $user_id;
        $user = User::find($user_id);
        $products = $user->product;
        $priceWithOffer=[];
        $i=0;

        foreach ($products as $product){
            // $productPrice[$i]= ($product->pivot->quantity)*($product->price);
             $product_offers=$product->offers;
            if( $product_offers && count($product_offers)>0)
            {
                foreach ($product_offers as $product_offer)
                    {
                        // return $product_offer;
                            $offer=(100-trim($product_offer->discount,"% , -"))/(100);
                            $priceWithOffer[$i]=($product->price)*($offer);
                            $productPrice[$i]= ($product->pivot->quantity)*($product->price)*($offer);
                            // return $pro->discount;
                    }
            }
            else{
                    $priceWithOffer[$i]=($product->price)*1;
                    $productPrice[$i]= ($product->pivot->quantity)*($product->price)*1;
                }
            $i++;
        }

        return view('front.cart-total',compact('products','productPrice','priceWithOffer'));
    }
    public function hotDeals($id)
    {
        //kda m3ana id al offer
      $offers=Offer::find($id);
      $products_offers=$offers->products;
      $discount_value=$offers->discount;
        return view('front.hot_deals',compact('products_offers','discount_value'));
    }
}
