<?php

namespace App\Http\Controllers\Front\Profile;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
        $user_id = Auth::user()->id;
        // return $user_id;
        $orders = Order::where('user_id','=', $user_id)->get();
        // $orders = Order::find('user_id',$user_id);
        // return $orders;
        $i=0;
        foreach($orders as $order){
            $products[$i] =  $order->products;
            
            return $products[$i];
            $i++;
        }
        return $products;
        return view('front.rating', compact('orders','products'));
    }
}
