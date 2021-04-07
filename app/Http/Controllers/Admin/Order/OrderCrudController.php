<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promocode;
use App\Models\Subcategory;
use App\Models\Supplier;
use App\User;
use Illuminate\Http\Request;
use Auth;

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
        return redirect('admin/order/admin-show-cart/'.$user_id);
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
        // return $price;
        // return $products;
        // return redirect('admin/order/admin-add-cart')->back()->with('products','price');
        //view('front.cart', compact('products','price'));

        $orders=Order::get();
        $user=User::get();
        return view('admin.order.show-all',compact('orders','user'));
    }
    public function delete(Request $request)
    {
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
        $user = User::find($user_id);
        $products = $user->product;
        $price=[];
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

        return view('admin.order.proceed-to-checkout',compact('user_id', 'products', 'productPrice','priceWithOffer'));
    }

    public function adminPlaceOrder(Request $request)
    {
        return $request;
    }
    public function orderProducts($id)
    {
        $brand=Brand::get();
        $subcategorys=Subcategory::get();
        $suppliers=Supplier::get();
        $order_Products=Order::with('products')->find($id);
        // return $order_Products->products;
        return view('admin.order.show-order-products',compact('order_Products','brand','subcategorys','suppliers'));
    }
}
