<?php

namespace App\Http\Controllers\Front\Profile;

use App\Http\Controllers\Controller;
use App\Mail\ChangeMail;
use App\Models\Address;
use App\Models\City;
use App\Models\Order;
use App\Models\Product;
use App\Models\Region;
use App\Models\Supplier;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user_id =  Auth::user()->id;
        $user_info = User::find($user_id);
        $regions = Region::get();
        $cities = City::get();
        $addresses = Address::where('user_id', '=', $user_id)->get();
        // return $address->flat;
        // return $addresses;
        return view('front.profile',compact('user_info','addresses', 'regions', 'cities'));
    }
    public function getRating()
    {
        // mnl orders...ngib bl user_id...l orders using l relation
        $suppliers=Supplier::get();
        $user_id = Auth::user()->id;
        // return $user_id;

        // with...btzabat l products fl orders...mn4er l loop li t7t "if($orders && count($orders)>0){"
        $orders = Order::with('products')->where('user_id','=', $user_id)->get();
        // print_r($orders);die;
        // $orders = Order::find('user_id',$user_id);
        // return $orders;

        // $products=[];
        // $i=0;
        // if($orders && count($orders)>0){
        //     foreach($orders as $order){
        //         $products[$i] =  $order->products;
        //         // return $products[$i];
        //         $i++;
        //     }
        // }else{
        //     $products[$i] =1;
        // }
        // return $products;
        return view('front.rating', compact('orders'/*,'products',*/,'suppliers'));
    }
    public function ProductRating(Request $request)
    {
        // $orders=Order::with('products')->find($order_id);
        // return $orders;
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
    public function ProductRatingInsert(Request $request){
        // return $request;
        // return $request->all();
        // $forgien_key=[];
        // $pivot_attribute=[];
        // $forgien_key['user_id']=$request->user_id;
        // $forgien_key['product_id']=$request->product_id;
        $i=0;
        // foreach($request->product_id as $product_id){
            for($i=0 ; $i<count($request->product_id) ; $i++){
                $forgien_key['product_id'] = $request->product_id[$i];
                // $forgien_key['user_id'] = $request->user_id;

                $pivot_attribute['value'] = $request->value[$i];
                // $pivot_attribute['comment'] = $request->only('comment_'.$i);
                // $pivot_attribute = $request->only('value_'.$i ,'comment_'.$i);
                $pivot_attribute['comment'] = $request->comment[$i];
                // print_r($pivot_attribute);
                // user_id should be given from the auth not from the from
                $user_id = Auth::user()->id;
                $user=User::findOrFail($user_id);
                $check=$user->productRate()->where('product_id', $forgien_key['product_id'])->exists();
                if($check){
                    // echo "check true";
                    // $user->productRate()->updateExistingPivot($request->product_id,$pivot_attribute);
                    $user->productRate()->updateExistingPivot($request->product_id[$i], $pivot_attribute);
                }
                else{
                    //  echo "check false";
                    $user->productRate()->attach($request->product_id[$i],$pivot_attribute);
                }
        }
        return redirect('profile');
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
        $new_mail=$request->email;
        $data=[];
        // $url=URL::temporarySignedRoute('check.url',now()->addMinute(30),['user-email'=>$request->email,'user-id'=>Auth::user()->id]);
        $url=URL::temporarySignedRoute('check.url',now()->addMinute(30),['id'=>Auth::user()->id,'email'=>$request->email]);
        $user_id=Auth::user()->id;
        $user_email=$request->email;
        $data['url']=$url;
        // return $data['url'];
        $sendmail = new ChangeMail($url,$user_email,$user_id);
        Mail::to($new_mail)->send($sendmail);
        // if ($request->hasValidSignature()) {
        //             // abort(401);
        //             return "update";
        //         }
        return $url;
        // return $request;
        $user_id = Auth::user()->id;
        $data = $request->except('_token');
        User::where('id','=', $user_id)->update($data);
        // User::where('id','=', $user_id)->sendEmailVerificationNotification();
        // User::where('id','=', $user_id)->verificationUrl();
        // return redirect()->back()->with('Success', 'Your Email Has Been Updated Successfully');
        return $request;
    }
    // public function checkUrl(Request $request)
    // {
    //     if(request()->hasValidSignature()){

    //     }
    // }

    public function profileChangePassword(Request $request)
    {
        //bycrpt
        $user_pass=Auth::user()->password;
        if (Hash::check($request->old_password, $user_pass))
        {
            if($request->password == $request->confirm_password){
                //update in user table
                $hashed_pass=Hash::make($request->confirm_password);
                // return $hashed_pass;
                $update=User::where('id','=', Auth::user()->id)->update(['password' => $hashed_pass]);
                    if($update){
                        return "updated";
                    }
                    else{
                        return "not updated";
                    }

            }
            else{
                return "pass doesnot match";
            }
        }else{
            return "wrong old password";
        }
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
        // return $cart;
        $regions = Region::get();
        $user_id = Auth::user()->id;

        return view('front.create-address-profile', compact('regions','user_id'));
    }

    public function profileStoreAddress(Request $request )
    {
        // return request()->previous()->segment(count(request()->segments()));
        // return Route::previous()->getName();
        // Route
        // return $request;
        // return URL::previous();


        // return app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName();
        // if(app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName() == 'public.contact'){
        //     return "ay klam ";
        // }
        // return $previous;
        // if($previous==1){
        //     return "true";
        // }
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
        $data = $request->except('_token','from');
        Address::insert($data);
        if($request->from=="cart"){
            return redirect('cart')->with('Success', 'Your Address Has Been Added Successfully');
        }else{
            return redirect('profile')->with('Success', 'Your Address Has Been Added Successfully');
        }

    }
    public function chooseAddress()
    {

    }
}
