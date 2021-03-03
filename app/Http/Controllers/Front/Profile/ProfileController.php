<?php

namespace App\Http\Controllers\Front\Profile;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\User;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    public function getProfile()
    {
        return view('front.profile');
    }
    public function getRating()
    {
        // mnl orders...ngib bl user_id...l orders using l relation
        $suppliers=Supplier::get();
        $user_id = Auth::user()->id;
        // return $user_id;
        $orders = Order::where('user_id','=', $user_id)->get();
        // $orders = Order::find('user_id',$user_id);
        // return $orders;
        $i=0;
        foreach($orders as $order){
            $products[$i] =  $order->products;
            // return $products[$i];
            $i++;
        }
        // return $products;
        return view('front.rating', compact('orders','products','suppliers'));
    }
    public function ProductRating(Request $request)
    {
        $order_id=$request->order_id;
        $products=Product::get();
        $suppliers=Supplier::get();
        $user_id = Auth::user()->id;
        $product_data=[];
        $i=0;
        foreach($request->id as $id){
              $product_data[$i]=$id;
              $i++;
        }
        // return $product_data;
        return view('front.product-rating',compact('order_id','products','product_data','suppliers','user_id'));
    }
    public function ProductRatingInsert(Request $request)
    {
        $forgien_key=[];
        $pivot_attribute=[];
        $forgien_key['user_id']=$request->user_id;
        $forgien_key['product_id']=$request->product_id;
        $pivot_attribute['value']=$request->value;
        $pivot_attribute['comment']=$request->comment;

        // return "wsgwdhs";
        $user=User::find($request->user_id);
        $check=$user->productRate()->where('product_id', $forgien_key['product_id'])->exists();
        if($check){
            $user->productRate()->updateExistingPivot($request->product_id,$pivot_attribute);
        }
        else{
            $user->productRate()->attach($forgien_key,$pivot_attribute);
        }

        return view('front.profile');
    }
}
