<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Promocode;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendMail;
use Carbon\Carbon;

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
        $user_id = Auth::user()->id;
        $data=$request->except('_token');
        $orderInsert['status']=0;//order placed
        $orderInsert['amount']=array_sum($request->quantity);
        $orderInsert['total_price']=array_sum($request->productPrice);
        $orderInsert['user_id']=Auth::user()->id;
        if($request->promoCodes_id){
            $orderInsert['promoCodes_id']=$request->promoCodes_id;
        }
        Order::insert($orderInsert);
        $now=Carbon::now();
        $order_id=Order::where('user_id','=',$user_id)->latest('id')->first();
        // $orderInsert['order_id_mail']=$order_id;
        $orderInsert['order_id']=$order_id->id;
        // return $order_id->id ;
        $orderInsert['title'] = 'Thank you for your order';
        $orderInsert['body'] = 'body is';

        // return $user_id;
        $user = User::find($user_id);
        $orderInsert['userName'] = $user->name;
        $products = $user->product;
        $i=0;
        foreach ($products as $product){
            foreach ($product->offers as $pro){
                $offer=(100-trim($pro->discount,"% , -"))/(100);
                $productPrice[$i]= ($product->pivot->quantity)*($product->price)*($offer);
                // return $productPrice;
            }
            // return $product->offers;
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
        $orderInsert['subtotal'] = $totalOrderValue;
        $orderInsert['payment_method'] = $paymentMethod;
        $discount = 1;

        $rangValue = 1;
        $out_of_date = 1;
        $flag = 0;
        $flag2=0;

        if($promoCode){
            $flag2 = 1;
            if($promoCode->start_date <= $ldate && $promoCode->expire_date >= $ldate){
                $flag = 1;
            }else{
                // promocode not applied (out of date)
                $out_of_date = "The entered promocode is out of date";
            }
            if($promoCode->minOrderValue <=$totalOrderValue &&
               $promoCode->maxOrderValue >=$totalOrderValue){
                   if($flag == 1){
                        $discount=$promoCode->discountValue;
                        $discount=(100-trim($discount=$promoCode->discountValue,"%"))/(100);
                   }
            }else{
                // promocode not applied (outside the order value--min or max)
                $rangValue = "Your order value is out of the range of the entered promocode";
            }
        }
        $orderInsert['discount'] = $discount;
        $orderInsert['flag'] = $flag2;
        $orderInsert['out_of_date'] = $out_of_date;
        $orderInsert['rangValue'] = $rangValue;
        // detach l cart
        // $user_id = Auth::user()->id;
        // $user = User::find($user_id)->product()->detach();

        //
        $Order_Product=[];
        $pivot_forgien=[];
        foreach ($products as $product){
            $pivot_forgien['product_id']= $product->id;
            $pivot_forgien['order_id']=$orderInsert['order_id'];

            // $order_id->products()->syncWithoutDetaching($pivot_forgien, $Order_Product);
            $Order_Product['quantity']=$product->pivot->quantity;
            $Order_Product['payment_method']=$orderInsert['payment_method'];
            $Order_Product['promocode']=$request->promoCodes_id;
            // return "ed";
            $order_id->products()->attach($pivot_forgien,$Order_Product);
            //attach(array want to change with forgirn key , attributes that will be changed)
            // $order_id->products()->syncWithoutDetaching($pivot_forgien, $Order_Product);
        }
        // return $Order_Product;
        $sendmail = new sendMail($orderInsert, $products);

        Mail::to(Auth::user()->email)->send($sendmail);
        // end of send mail
        return view('front.order-done',compact('products','productPrice','promoCode','paymentMethod','discount', 'rangValue', 'out_of_date'))->with('Success','Your Order Has Been Placed');
    }

}
