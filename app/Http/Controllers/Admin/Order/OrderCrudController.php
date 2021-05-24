<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Mail\sendMail;
use App\Models\Address;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promocode;
use App\Models\Region;
use App\Models\Subcategory;
use App\Models\Supplier;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderCrudController extends Controller
{
    public function getUser(){
        $users = User::get();
        return view('admin.order.select-user', compact('users'));
    }

    public function selectUserAndAddToCart(Request $request){
        $rules=[
            'user_id' => 'required|exists:users,id',
        ];
        $request->validate($rules);
        $user_id = $request->user_id;
        return redirect('admin/order/admin-proceed-checkout/'.$user_id);
    }
    public function AdminShowCart($user_id){
        // 2) get cart
        // return $user_id;
        $user = User::find($user_id);
        $products = $user->product;
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

        $categories = Category::get();
        $promocodes = Promocode::get();
        return view('admin.order.create-order',compact('products','price','categories','promocodes','user_id'));
    }
    //
    public function show(){
        $orders=Order::get();
        $users=User::get();
        // $order_product_status=Order::with('products')->get();
        // $i=0;
        // $arr=[];
        // foreach($order_product_status as $order_product){
        //     return $order_product->products;
        //     // $arr['product_id']=$order_product->products[$i]->pivot->status;
        //     // for($i=0;$i<count($order_product->products[$i]->pivot->status);$i++){

        //     // }
        //     $arr['status']=$order_product->products[$i]->pivot->status;
        //     $i++;
        // }
        // print_r($arr);die;
        // return $order_product_status;

        return view('admin.order.show-all',compact('orders','users'));
    }
    public function delete(Request $request){
       $rule=[
        "id"=>'required|exists:orders,id|integer'
        ];
        $request->validate($rule);
        Order::destroy($request->id);
        return redirect()->back()->with('Success','The Order Has Been Deleted');
    }
    public function update($id,$action)
    {
       $order=Order::where('id','=',$id)->first();
       //change th status of message according to the action
       $order->status=$action;
       $order->save();
       return redirect()->back()->with('Success','The Order\'s Status Has Been updated');
    }

    // add order using Ajax
    // public function add()
    // {
    //     $categories = Category::get();
    //     $users = User::get();
    //     $promocodes = Promocode::get();
    //     return view('admin.order.create-order', compact('categories','users','promocodes'));
    // }

    public function getSubcategoriesByCategoryId(Request $request)
    {
        $data = Subcategory::where('category_id','=', $request->category_id)->get();
        return response()->json($data);
    }
    public function getProductsBySubcategoryId(Request $request)
    {
        $data = Product::where('subCategory_id','=', $request->subcategory_id)->get();
        return response()->json($data);
    }

    public function adminAddToCart(Request $request)
    {
        $rules=[
                "product_id"=>'required|exists:products,id',
               "quantity"=>'required|integer',
                "user_id" => 'required|exists:users,id',
                // "master_number" => '',
        ];
        $request->validate($rules);
        // 1) add to cart
        $user = User::find($request->user_id);
        $user->product()->syncWithoutDetaching($request->product_id, ['quantity' => $request->quantity]);
        Product::find($request->product_id)->user()->updateExistingPivot($request->user_id, ['quantity' => $request->quantity]);
        return redirect()->back()->with('Success', 'Added Successfully to Cart');
    }
    public function AdminCartProductDelete(Request $request)
    {
        $rules=[
            'product_id' => 'required|exists:products,id|integer',
            'user_id' => 'required|exists:users,id|integer',
        ];
        $request->validate($rules);
        // return $request;
        $user = User::find($request->user_id)->product()->detach($request->product_id);
        return redirect()->back()->with('Success', 'Your Cart Has Been Updated');
    }

    public function adminProceedToCheckout($user_id)
    {
        // $users=User::get();

        $addresses = Address::where('user_id', '=', $user_id)->get();
        $regions=Region::get();
        $cities=City::get();
        $categories=Category::get();
        $user_id=$user_id;
        $user = User::find($user_id);
        $products = $user->product;
        $price=[];
        $productPrice=[];
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

        return view('admin.order.proceed-to-checkout',compact('categories','products','user_id','priceWithOffer','productPrice','cities','regions','addresses'));
    }

    public function adminPlaceOrder(Request $request)
    {
        $orders=Order::get();
        $users=User::get();
        $user_id=$request->user_id;
        $orderInsert=[];
        $dbInsertInOrder=[];
        $address=Address::where('id','=',$request->address_id)->first();
        $regions = Region::get();
        $cities = City::get();
        $promocodeId=Promocode::where('name','=',$request->promoCodes_id)->first()->id;
        $promocode=Promocode::where('name','=',$request->promoCodes_id)->first();
        $promocode_max_usage=Promocode::where('name','=',$request->promoCodes_id)->first()->max_usage;
        $promocodeId_max_usage_per_user=Promocode::where('name','=',$request->promoCodes_id)->first()->max_usage_per_user;

        // $products=[];
        $orderInsert['total_price']=0;
        foreach($request->product_id as $key => $product_id){
            $index=$request->quantity[$key];

            $products = Product::leftJoin('offer_product', 'offer_product.product_id', '=', 'products.id')
            ->leftJoin('offers', 'offer_product.offer_id', '=', 'offers.id'/*, 'left outer'*/)
            ->select('products.id as product_id',
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
            DB::raw("products.price * IF(
                offers.discount IS NULL,
                1,
                ((100 - offers.discount) / 100)
            ) * '$index' AS `total_price_after_discount`"))
        ->orderBy('products.id', 'asc')
        ->where('products.id','=',$product_id)->first();
        $orderInsert['total_price']+=$products->total_price_after_discount;
        }
        // return $request->product_id;
        // return $products;
        $orderInsert['status']=0;//order placed
        $orderInsert['address_id']=$request->address_id;
        $orderInsert['amount']=array_sum($request->quantity);
        // $orderInsert['total_price']=0;
        // foreach( $products as $price){
        //     $orderInsert['total_price']+=$price->total_price_after_discount;
        // }
        $orderInsert['user_id']=$request->user_id;
        if($request->promoCodes_id){
            $orderInsert['promoCodes_id']=$request->promoCodes_id;
            $dbInsertInOrder['promoCodes_id']=$request->promoCodes_id;
            }
        // Order::insert($orderInsert);
        // return"m";
        // $dbInsertInOrder[]=$orderInsert;
        $dbInsertInOrder['total_price']=$orderInsert['total_price'];
        $dbInsertInOrder['status']=0;//order placed
        $dbInsertInOrder['address_id']=$request->address_id;
        $dbInsertInOrder['amount']=array_sum($request->quantity);
        $dbInsertInOrder['user_id']=$request->user_id;
        $orderInsert['address']=$address;
        $orderInsert['regions']=$regions;
        $orderInsert['cities']=$cities;

        $now=Carbon::now();

        // return $order_id;

        // return $order_id->id ;
        $orderInsert['title'] = 'Thank you for your order';
        $orderInsert['body'] = 'body is';
        // return $user_id;
        $user = User::find($request->user_id);
        $orderInsert['userName'] = $user->name;

        // $products = $user->product;
        // $products=Product::leftJoin('offer_product', 'offer_product.product_id', '=', 'products.id')
        // ->leftJoin('offers', 'offer_product.offer_id', '=', 'offers.id'/*, 'left outer'*/)
        //             ->join('carts','carts.product_id','=','products.id')
        //             ->select('carts.user_id as user_id','carts.quantity as quantity',
        //                 'products.id as product_id',
        //                 'products.photo as product_photo',
        //                 'products.*',
        //                 'offers.*',
        //                 "offers.id as offer_id",
        //                 DB::raw('IF(
        //                     offers.discount IS NULL,
        //                     1,
        //                     ((100 - offers.discount) / 100)
        //                 ) AS `discount`') ,
        //                 DB::raw('products.price * IF(
        //     offers.discount IS NULL,
        //     1,
        //     ((100 - offers.discount) / 100)
        // ) AS `price_after_discount`'),
        //                 DB::raw('products.price * IF(
        //                     offers.discount IS NULL,
        //                     1,
        //                     ((100 - offers.discount) / 100)
        //                 ) * carts.quantity AS `total_price_after_discount`'))
        //             ->orderBy('products.id', 'asc')->get();
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
        $totalOrderValue=$orderInsert['total_price'];
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
                            $data['user_id']=$request->user_id;
                            $data['promocode_id']=$promocodeId;
                            // $data['order_id']=$order_id->id;
                            // $user->promocodes()->attach($promocodeId, $data);
                            $dbInsertInOrder['total_price_after_promocode']=$orderInsert['total_price']*$discountOfPromocode;
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

        $x = Order::insert($dbInsertInOrder);
        $order_id=Order::where('user_id','=',$request->user_id)->latest('id')->first();
        $orderInsert['order_id_mail']=$order_id;
        $orderInsert['order_id']=$order_id->id;



        $orderInsert['discountOfPromocode'] = $discountOfPromocode;
        $orderInsert['flag'] = $flag2;
        $orderInsert['out_of_date'] = $out_of_date;
        $orderInsert['rangValue'] = $rangValue;
        $orderInsert['usage']=$usage;
        // detach l cart
        // $user_id = Auth::user()->id;
        // $user = User::find($request->user_id)->product()->detach();
        $Order_Product=[];
        $pivot_forgien=[];
        // foreach ($products as $key => $product){
            foreach($request->product_id as $key => $product_id){
                $index=$request->quantity[$key];
    
                $products = Product::leftJoin('offer_product', 'offer_product.product_id', '=', 'products.id')
                ->leftJoin('offers', 'offer_product.offer_id', '=', 'offers.id'/*, 'left outer'*/)
                ->select('products.id as product_id',
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
                DB::raw("products.price * IF(
                    offers.discount IS NULL,
                    1,
                    ((100 - offers.discount) / 100)
                ) * '$index' AS `total_price_after_discount`"))
            ->orderBy('products.id', 'asc')
            ->where('products.id','=',$product_id)->first();
            //////////////
            // return $products;
            $pivot_forgien['product_id']= $products->product_id;
            $pivot_forgien['order_id']=$order_id->id;
            // $order_id->products()->syncWithoutDetaching($pivot_forgien, $Order_Product);
            // $Order_Product['order_id']=$order_id->id;
            $Order_Product['quantity']=$request->quantity[$key];
            $Order_Product['payment_method']=$orderInsert['payment_method'];
            $Order_Product['promocode']=$request->promoCodes_id;
            $Order_Product['price']=$products->price;
            $Order_Product['offer_id']=$products->offer_id;
            $Order_Product['price_after_offer_discount']=$products->total_price_after_discount;
            // return "ed";
            $order_id->products()->attach($products->product_id,$Order_Product);
            }
            // return "mmmm";
            //attach(array want to change with forgirn key , attributes that will be changed)
            // $order_id->products()->syncWithoutDetaching($pivot_forgien, $Order_Product);
        // }
        // return $Order_Product;
        $orderInsert['user_id'] = $request->user_id;
        $products['user_id'] = $request->user_id;
        return $products;

        $sendmail = new sendMail($orderInsert, $products);
        $user_details=User::find($request->user_id);
        Mail::to($user_details->email)->send($sendmail);
        // end of send mail
        // return redirect('place-order')->with('products','productPrice','promoCode','paymentMethod','discount', 'rangValue', 'out_of_date');
        return "mmmm";
        return view('admin.order.show-all',compact('products','user_id','promocode_type','users','orders'/*,'productPrice','priceWithOffer'*/,'promoCode','paymentMethod','discountOfPromocode', 'rangValue','usage', 'out_of_date','address','regions','cities'))->with('Success','Your Order Has Been Placed');







    }
    public function orderProducts($id, $user_id)
    {
        $offers=Offer::get();
        $brand=Brand::get();
        $subcategorys=Subcategory::get();
        $suppliers=Supplier::get();
        $order_Products=Order::with('products')->find($id);

//         SELECT
// 	`orders`.*,
//     SUM(
//         CASE WHEN `order_product`.`status` = 1 THEN 1 ELSE 0
//     END
// ) AS `onee`,
// SUM(
//     CASE WHEN `order_product`.`status` = 2 THEN 1 ELSE 0
// END
// ) AS `twoo`,
// SUM(
//     CASE WHEN `order_product`.`status` = 0 THEN 1 ELSE 0
// END
// ) AS `zeroo`,
// SUM(
//     CASE WHEN `order_product`.`status` IS NULL THEN 1 ELSE 0
// END
// ) AS `nulll`
// FROM
//     `order_product`
// JOIN `orders` ON `orders`.`id` = `order_product`.`order_id`

// GROUP BY `orders`.`id`

        // return $order_Products->products;
        // return $user_id;
        return view('admin.order.show-order-products',compact('user_id','order_Products','brand','subcategorys','suppliers','offers'));
    }

    public function appologize($product_id, $user_id, $order_id)
    {
        $user = User::find($user_id);
        $product = Product::find($product_id);
        $details = [
            'title' => 'Appologizing Mail',
            'body' => 'We are sorry, the below product will not be delivered with your order',
        ];
        // Mail::to($user->email)->send(new \App\Mail\AppologizeMail($details, $user, $product));

        // change l status of l product in order-product table

        $order = Order::with('products')->find($order_id);
        foreach($order->products as $order_products){
            if($order_products->id == $product_id){
                Order::find($order_id)->products()->updateExistingPivot($product_id, ['status' => 2]);
            }
        }

        $offers=Offer::get();
        $brand=Brand::get();
        $subcategorys=Subcategory::get();
        $suppliers=Supplier::get();
        $order_Products=Order::with('products')->find($order_id);
        // return $order_Products->products;
        // return $user_id;
        return view('admin.order.show-order-products',compact('user_id','order_Products','brand','subcategorys','suppliers','offers'));
    }


    public function getneworder()
    {
        $users=User::get();
        $categories=Category::get();
        $addresses = Address::get();
        $regions=Region::get();
        $cities=City::get();
        return view('admin.order.order-try',compact('users','categories','addresses','regions','cities'));
    }
}
