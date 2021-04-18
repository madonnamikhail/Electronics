<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Promocode;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendMail;
use App\Models\Address;
use App\Models\City;
use App\Models\Product;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function placeOrder(Request $request){
        // return $request;
        $rules=[
            // "photo"=>'required|mimes:png,jpg,jpeg|max:1024',
            // "name"=>'required|exists:products,name_en',
            // "price"=>'required|exists:products,price',
            // "quantity"=>'required',
            // "productPrice"=>'required',
            // //  "master_number"=>''
            // "promoCodes_id"=>'exists:promocodes,name',
            // "method_payment"=>'required'
        ];
        $request->validate($rules);
        // return "ok";
        $user_id = Auth::user()->id;
        $data=$request->except('_token');
        // return $data;
        //get address to deliver
        $address=Address::where('id','=',$request->address_id)->first();
        $regions = Region::get();
        $cities = City::get();
        // 1) insert in orders' table

        $promocodeId=Promocode::where('name','=',$request->promoCodes_id)->first()->id;
        $promocode=Promocode::where('name','=',$request->promoCodes_id)->first();
        $promocode_max_usage=Promocode::where('name','=',$request->promoCodes_id)->first()->max_usage;
        $promocodeId_max_usage_per_user=Promocode::where('name','=',$request->promoCodes_id)->first()->max_usage_per_user;
        // return $promocodeId;
        $orderInsert['status']=0;//order placed
        $orderInsert['address_id']=$request->address_id;
        $orderInsert['amount']=array_sum($request->quantity);
        $orderInsert['total_price']=array_sum($request->productPrice);
        $orderInsert['user_id']=Auth::user()->id;
        if($request->promoCodes_id){
            $orderInsert['promoCodes_id']=$request->promoCodes_id;
            $dbInsertInOrder['promoCodes_id']=$request->promoCodes_id;
            }
        // Order::insert($orderInsert);
        // return "m";
        // $dbInsertInOrder[]=$orderInsert;
        $dbInsertInOrder['total_price']=array_sum($request->productPrice);
        $dbInsertInOrder['status']=0;//order placed
        $dbInsertInOrder['address_id']=$request->address_id;
        $dbInsertInOrder['amount']=array_sum($request->quantity);
        $dbInsertInOrder['total_price']=array_sum($request->productPrice);
        $dbInsertInOrder['user_id']=Auth::user()->id;
        // Order::insert($dbInsertInOrder);
        // return $dbInsertInOrder;
        $orderInsert['address']=$address;
        $orderInsert['regions']=$regions;
        $orderInsert['cities']=$cities;
        // return $orderInsert['address']->flat;
        // 2)
        $now=Carbon::now();
        $order_id=Order::where('user_id','=',$user_id)->latest('id')->first();
        // return $order_id;
        // $orderInsert['order_id_mail']=$order_id;
        $orderInsert['order_id']=$order_id->id;
        // return $order_id->id ;
        $orderInsert['title'] = 'Thank you for your order';
        $orderInsert['body'] = 'body is';
        // return $user_id;
        $user = User::find($user_id);
        $orderInsert['userName'] = $user->name;
        // $products = $user->product;
        $products=Product::leftJoin('offer_product', 'offer_product.product_id', '=', 'products.id')
        ->leftJoin('offers', 'offer_product.offer_id', '=', 'offers.id'/*, 'left outer'*/)
                    ->join('carts','carts.product_id','=','products.id')
                    ->select('carts.user_id as user_id','carts.quantity as quantity',
                        'products.id as product_id',
                        'products.photo as product_photo',
                        'products.*',
                        'offers.*',
                        "offers.id as offer_id",
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
        $promoCode=$request->promoCodes_id;
        if($request->method_payment == 0.9){
            $paymentMethod="Master Card ( 10% Discount )";
        }
        elseif($request->method_payment == 5){
            $paymentMethod="Cash On Delivery ( +5 EGP )";
        }
        $promoCode=Promocode::where('name','=',$request->promoCodes_id)->first();
        $ldate = date('Y-m-d');
        // $totalOrderValue=array_sum($request->productPrice); //mn4er offers..3shan tgili fl mail
        $totalOrderValue=array_sum($request->productPrice);
        $orderInsert['subtotal'] = $totalOrderValue;
        $orderInsert['payment_method'] = $paymentMethod;
        $discountOfPromocode = 1;

        $rangValue = 1;
        $usage=1;

        $out_of_date = 1;
        $flag = 0;
        $flag2=0;
        //to get user and promocode
        $maxUsage=User::Join('user_promocode','user_promocode.user_id','=','users.id','left outer')
                    ->join('promocodes','user_promocode.promocode_id','=','promocodes.id' ,'left outer')
                    ->join('orders','user_promocode.order_id','=','orders.id' ,'left outer')
                    ->select(//'users.id as user_id',
                            // 'promocodes.id as promocode_id',
                            // 'promocodes.name',
                            // 'promocodes.type',
                            // 'promocodes.max_usage',
                            // 'promocodes.max_usage_per_user',
                            'user_promocode.promocode_id',
                            // 'user_promocode.user_id',
                            // 'user_promocode.order_id',
                            DB::raw('count(user_promocode.promocode_id) as maxUsage'),
                          /*  DB::raw('count(user_promocode.user_id) as maxUsagePerUser'),*/)

                    ->groupBy(/*'user_promocode.user_id','users.id',*/'user_promocode.promocode_id'/*'promocodes.id',
                            'promocodes.name','promocodes.type',
                            'promocodes.max_usage',*/
                            /*'promocodes.max_usage_per_user','user_promocode.order_id'*/)
                    // ->where('users.id','=',$user_id)
                    ->where('promocodes.id','=',$promocodeId)
                    ->first()->maxUsage;
        // return $maxUsage;

        $maxUsagePerUser=User::Join('user_promocode','user_promocode.user_id','=','users.id','left outer')
                            ->join('promocodes','user_promocode.promocode_id','=','promocodes.id' ,'left outer')
                            ->join('orders','user_promocode.order_id','=','orders.id' ,'left outer')
                            ->select('user_promocode.user_id',DB::raw('count(user_promocode.user_id) as maxUsagePerUser'))
                            ->groupBy('user_promocode.user_id')
                            ->where('promocodes.id','=',$promocodeId)
                            ->first()->maxUsagePerUser;
        //  return $maxUsagePerUser;
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

                        $discountOfPromocode=$promoCode->discountValue;
                        // return $discount;
                        $promocode_type= $promoCode->type;
                        if($promocode_type){
                            $discountOfPromocode=(100-trim($discountOfPromocode=$promoCode->discountValue,"%"))/(100);
                        }else
                        {
                            $discountOfPromocode=$promoCode->discountValue;
                        }
                        // $discount=(100-trim($discount=$promoCode->discountValue,"%"))/(100);
                        //check for max_usage & max_user_usage
                        if($maxUsage<$promocode_max_usage && $maxUsagePerUser < $promocodeId_max_usage_per_user){
                            //user_id & promocode_id
                            $data=[];
                            $data['user_id']=$user_id;
                            $data['promocode_id']=$promocodeId;
                            $data['order_id']=$order_id->id;
                            $user->promocodes()->attach($promocodeId, $data);
                            $dbInsertInOrder['total_price_after_promocode']=$dbInsertInOrder['total_price']*$discountOfPromocode;

                        }
                        else{
                            $usage= "promocode is not valid";
                        }
                   }
            }else{
                // promocode not applied (outside the order value--min or max)
                $rangValue = "Your order value is out of the range of the entered promocode";
            }
        }

        // return $dbInsertInOrder;
        Order::insert($dbInsertInOrder);

        $orderInsert['discountOfPromocode'] = $discountOfPromocode;
        $orderInsert['flag'] = $flag2;
        $orderInsert['out_of_date'] = $out_of_date;
        $orderInsert['rangValue'] = $rangValue;
        $orderInsert['usage']=$usage;
        // detach l cart
        // $user_id = Auth::user()->id;
        $user = User::find($user_id)->product()->detach();
        $Order_Product=[];
        $pivot_forgien=[];
        foreach ($products as $product){
            $pivot_forgien['product_id']= $product->product_id;
            $pivot_forgien['order_id']=$orderInsert['order_id'];
            // $order_id->products()->syncWithoutDetaching($pivot_forgien, $Order_Product);
            $Order_Product['quantity']=$product->quantity;
            $Order_Product['payment_method']=$orderInsert['payment_method'];
            $Order_Product['promocode']=$request->promoCodes_id;
            $Order_Product['price']=$product->price;
            $Order_Product['offer_id']=$product->offer_id;
            $Order_Product['price_after_offer_discount']=$product->total_price_after_discount;
            // return "ed";
            $order_id->products()->attach($product->product_id,$Order_Product);
            //attach(array want to change with forgirn key , attributes that will be changed)
            // $order_id->products()->syncWithoutDetaching($pivot_forgien, $Order_Product);
        }
        // return $Order_Product;
        $orderInsert['user_id'] = $user_id;
        $orderInsert['user_id'] =
        // return $Order_Product;
        $sendmail = new sendMail($orderInsert, $products);
        Mail::to(Auth::user()->email)->send($sendmail);
        // end of send mail
        // return redirect('place-order')->with('products','productPrice','promoCode','paymentMethod','discount', 'rangValue', 'out_of_date');
        return view('front.order-done',compact('products','user_id','promocode_type'/*,'productPrice','priceWithOffer'*/,'promoCode','paymentMethod','discountOfPromocode', 'rangValue','usage', 'out_of_date','address','regions','cities'))->with('Success','Your Order Has Been Placed');
    }

}
