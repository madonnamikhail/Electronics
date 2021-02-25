<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Promocode;
use App\User;
use Illuminate\Http\Request;
use Auth;

class OrderController extends Controller
{
    //

    public function placeOrder(Request $request){

        $rules=[
        //     "photo"=>'image|mimes:png,jpg,jepg|max:1024',
        //     "name"=>'required',
        //     "price"=>'required',
        //     "quantity"=>'required|integer',
        //     "productPrice"=>'required',
            "method_payment"=>'required'
        ];
        $request->validate($rules);
        $data=$request->except('_token');
        $orderInsert['status']=1;//order placed
        $orderInsert['amount']=count($request->photo);
        $orderInsert['total_price']=array_sum($request->productPrice);
        $orderInsert['user_id']=Auth::user()->id;
        if($request->promoCodes_id){
            $orderInsert['promoCodes_id']=$request->promoCodes_id;
        }
        // $imageName= $this->UploadPhoto($request->photo , 'product');
        // $data=$request->except('photo','_token');
        // // $data['photo']=$imageName;
        Order::insert($orderInsert);
        $user_id = Auth::user()->id;
        // return $user_id;
        $user = User::find($user_id);
        $products = $user->product;
        $i=0;
        foreach ($products as $product){
            $productPrice[$i]= ($product->pivot->quantity)*($product->price);
            $i++;
        }
        $promoCode=$request->promoCodes_id;
        if($request->method_payment == 0.9){
            $paymentMethod="Master Card ( 10% Discount )";
        }
        elseif($request->method_payment == 5){
            $paymentMethod="Cash On Delivery ( +5 EGP )";
        }
        $promoCode=Promocode::where('name','=',$request->promoCodes_id)->first();
        $ldate = date('Y-m-d');
        $totalOrderValue=array_sum($request->productPrice);
      
        if($promoCode){
            if($promoCode->start_date <= $ldate && $promoCode->expire_date >= $ldate){
                if( $promoCode->minOrderValue <=$totalOrderValue && $promoCode->maxOrderValue >=$totalOrderValue ){

                    $discount=$promoCode->discountValue;
                    $discount=(100-trim($discount=$promoCode->discountValue,"%"))/(100);
                }
            }
        }
        return view('front.order-done',compact('products','productPrice','promoCode','paymentMethod','discount'))->with('Success','Your Order Has Been Placed');
    }

}
