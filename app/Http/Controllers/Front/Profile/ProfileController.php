<?php

namespace App\Http\Controllers\Front\Profile;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\City;
use App\Models\Order;
use App\Models\Product;
use App\Models\Region;
use App\Models\Supplier;
use App\User;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user_id =  Auth::user()->id;
        $user_info = User::find($user_id);
        $regions = Region::get();
        $cities = City::get();
        $address = Address::where('user_id', '=', $user_id)->first();
        // return $address->flat;
        // return $addresses;
        return view('front.profile',compact('user_info','address', 'regions', 'cities'));
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
            $user->productRate()->attach($request->product_id,$pivot_attribute);
        }

        return view('front.profile');
    }

    public function profileChangeInfo(Request $request)
    {
        $rules = [
            'name' => 'max:100|string',
            'phone' => 'digits:11|numeric',
        ];
        $request->validate($rules);
        $user_id = Auth::user()->id;
        // return $request;
        // update
        $data = $request->except('_token','submit_info');
        User::where('id','=', $user_id)->update($data);
        return redirect()->back()->with('Success', 'Your Info Has Been Updated Successfully');
        // return $request;
    }
    public function profileChangeEmail(Request $request)
    {
        
        $rules=[
            'email' =>'email:rfc,dns',
        ];
        $request->validate($rules);
        $user_id = Auth::user()->id;
        $data = $request->except('_token');
        User::where('id','=', $user_id)->update($data);
        // User::where('id','=', $user_id)->sendEmailVerificationNotification();
        // User::where('id','=', $user_id)->verificationUrl();
        // return redirect()->back()->with('Success', 'Your Email Has Been Updated Successfully');
        return $request;
    }

    public function profileChangePassword(Request $request)
    {
        //bycrpt
        return $request;
    }
    public function profileDeleteAddress(Request $request)
    {
        // return $request;
        $rule=[
            "address_id"=>'required|exists:addresss,id|integer'
        ];
        // return $request;
        $request->validate($rule);
        Address::destroy($request->address_id);
        return redirect()->back()->with('Success', 'Your Address Has Been Deleted Successfully');;

    }
    
    public function profileEditAddress($id)
    {
        $regions = Region::get();
        $cities = City::get();
        $address = Address::find($id);
        $user_id = Auth::user()->id;
        // return $address;
        return view('front.edit-address-profile', compact('regions','cities','address','user_id'));
    }

    public function profileChangeAddress(Request $request, $id)
    {
        $rules=[
            'flat' =>'required|numeric',
            'building' => 'required|numeric',
            'floor'=>'required|numeric',
            'street_en'=>'required|string',
            'user_id'=>'required|exists:users,id',
            'region_id'=>'required|exists:regions,id',
        ];
        $request->validate($rules);
        // return $request;
        $data = $request->except('_token');
        Address::where('user_id','=',$request->user_id)->update($data);
        return redirect('profile')->with('Success', 'Your Address Has Been Updated Successfully');
    }

    public function profileCreateAddress()
    {
        $regions = Region::get();
        $user_id = Auth::user()->id;
        return view('front.create-address-profile', compact('regions','user_id'));
    }

    public function profileStoreAddress(Request $request)
    {
        // return $request;
        // return $request;
        $rules=[
            'flat' =>'required|numeric',
            'building' => 'required|numeric',
            'floor'=>'required|numeric',
            'street_en'=>'required|string',
            'user_id'=>'required|exists:users,id',
            'region_id'=>'required|exists:regions,id',
        ];
        $request->validate($rules);
        // return $request;
        $data = $request->except('_token');
        Address::insert($data);
        return redirect('profile')->with('Success', 'Your Address Has Been Added Successfully');

    }
}
