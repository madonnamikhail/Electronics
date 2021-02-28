<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\User;
use Illuminate\Http\Request;
use Auth;

class OrderCrudController extends Controller
{
    //
    public function show()
    {
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
}
