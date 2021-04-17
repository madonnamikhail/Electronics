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

    public function supplierCanDeliver($product_id, $order_id)
    {
        $rules = [
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id'
        ];
        $idd = [];
        $idd['product_id'] = $product_id;
        $idd['order_id'] = $order_id;
        $validator = Validator::make($idd,$rules);
        if ($validator->fails()) {
            return abort(404);
        }
        $orders=Order::with('products')->where('id','=',$order_id)->get();

        // looping to get the right product_id && update its status in order_product
        foreach ($orders as $order) {
            foreach ($order->products as $product){
                if($product->id == $product_id){
                    Order::find($order_id)->products()->updateExistingPivot($product_id, ['status' => 1]);
                }
            }
        }
        return redirect()->back()->with('Success','Product can be delivered to the customer');
        // $order=Order::where('id','=',$order_id)->has('products')->with('products.id')->get();
        // $matches = Criteria::whereUserId( Auth::id() )
        //                     ->has('alerts')
        //                     ->with('alerts.location', 'alerts.user.companies')
        //                     ->withPivot('foo', 'bar'); //pivot table columns you need from pivot table criteria_alert
        //                     ->get();

        // $order->where('product_id','=',$product_id)->get();
        // $order->status=1;
        // $order->save();
        // return $order;
        // return $product_id . ' ' . $order_id;
    }

    public function supplierCannotDeliver($product_id, $order_id)
    {
        $rules = [
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id'
        ];
        $idd = [];
        $idd['product_id'] = $product_id;
        $idd['order_id'] = $order_id;
        $validator = Validator::make($idd,$rules);
        if ($validator->fails()) {
            return abort(404);
        }
        $orders=Order::with('products')->where('id','=',$order_id)->get();

        // looping to get the right product_id && update its status in order_product
        foreach ($orders as $order) {
            foreach ($order->products as $product){
                if($product->id == $product_id){
                    Order::find($order_id)->products()->updateExistingPivot($product_id, ['status' => 0]);
                }
            }
        }
        return redirect()->back()->with('Error','Product cannot be delivered to the customer');
    }
}
