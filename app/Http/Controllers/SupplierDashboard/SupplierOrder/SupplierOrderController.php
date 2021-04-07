<?php

namespace App\Http\Controllers\SupplierDashboard\SupplierOrder;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupplierOrderController extends Controller
{
    public function getCreatedOrders()
    {
        $brand=Brand::get();
        $subcategorys=Subcategory::get();
        $orders = Order::with('products')->where('status','=',0)->get();
        // return $orders;
        return view('supplier.orders.supplier-created-order-products',compact('brand','subcategorys','orders'));
    }

    public function getInProgressOrders()
    {
        $brand=Brand::get();
        $subcategorys=Subcategory::get();
        $orders = Order::with('products')->where('status','=',1)->get();
        return view('supplier.orders.supplier-order-products',compact('brand','subcategorys','orders'));
    }

    public function getDeliveredOrders()
    {
        $brand=Brand::get();
        $subcategorys=Subcategory::get();
        $orders = Order::with('products')->where('status','=',2)->get();
        return view('supplier.orders.supplier-order-products',compact('brand','subcategorys','orders'));
    }

    public function update($id)
    {
        $rules = [
            'id' => 'required|exists:orders,id'
        ];
        $idd = [];
        $idd['id'] = $id;
        $validator = Validator::make($idd,$rules);
        if ($validator->fails()) {
            return abort(404);
        }
        $order=Order::where('id','=',$id)->first();
        $order->status=1;
        $order->save();
        return redirect()->back()->with('Success','The Order\'s Status Has Been updated');
    }
}
