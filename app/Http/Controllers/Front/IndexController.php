<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
use Auth;

class IndexController extends Controller
{
    public function index()
    {
        $products = Product::get();
        $i =0;
        foreach ($products as $product) {
            $offers[$i] = Offer::select('discount')->where('id', '=', $product->offer_id)->get();
            $i++;
        }
        return view('front.userindex', compact('products', 'offers'));
    }
    public function addCart(Request $request)
    {
        // user_id, product_id
        // fl pivot--carts
        // return $request;
        // rules
        // $product = Product::find(3);
        // return $product->user;
        $rules =[
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ];
        $product = Product::find($request->product_id);
        $user = User::find($request->user_id);
        // validator
        $request->validate($rules);
        $data=$request->except('_token');
        // add record in pivot "cart"
        // return $product;
        $user->product()->syncWithoutDetaching($data);
        // $product->user()->attach($data);
        return redirect()->back()->with('Success', 'Added Successfully to Cart');
    }

    public function getCart()
    {
        // get l carts
        $user_id = Auth::user()->id;
        // return $user_id;
        $user = User::find($user_id);
        $products = $user->product;
        // return $products;
        return view('front.cart', compact('products'));
    }

    public function cartClear()
    {
        $user_id = Auth::user()->id;
        // return $user_id;
        // $user = User::find($user_id);
        // $products_cart = $user->product;
        // return "ok";
        // return $products_cart;
        // foreach($products_cart as $product_cart){
        //     $user->product()->detach($product_cart->pivot->product_id);
        // }
        // ReportMessages::find(1)->reports()->where('report_id',$report_id)->delete();
        $user = User::find($user_id)->product()->detach();
        // $user->product()->detach();
        // $user->delete
        return redirect()->back()->with('Success', 'Your Cart Has Been Cleared');
    }

    public function cartProductEdit($product_id)
    {
        $product = Product::find($product_id);
        $quantities = $product->user;
        foreach ($quantities as $quantity) {
            $product_quantity =  $quantity->pivot->quantity;
        }
        // return $product_quantity;
        return view('front.editCart', compact('product', 'product_quantity'));
    }

    public function cartProductUpdate(Request $request, $id)
    {
        $rules=[
            'product_quantity' => 'required|integer',
        ];
        $request->validate($rules);
        // $data=$request->except('_token');

        // $product = Product::find($id);

        // $product->user()->updateExistingPivot($product, $request->product_quantity);
        // $quantities = $product->user;
        // foreach ($quantities as $quantity) {
            // $quantity->pivot->quantity = $request->product_quantity;
            Product::find($id)->user()->updateExistingPivot($request->quantity, ['quantity' => $request->quantity]);
            // Product::find($id)->user()->save($request->quantity, ['quantity' => $request->quantity]);
        // }

        // $invoice = Invoice::findOrFail($id);
        // $invoice->update([
        // 'number' => $request->number,
        // 'status' => $request->status,
        // 'place_issue' => $request->place_issue,
        // 'date_issue' => $request->date_issue,
        // 'date_payment' => $request->date_payment,
        // 'description' => $request->description,
        // 'company_id' => $request->company_id,
        // 'user_id' => $request->user_id,
        // ]);
        // Product::find($id)->user()->updateExistingPivot($request->quantity, ['quantity' => $request->quantity]);
        return redirect('/cart')->with('Success', 'Your Cart Has Been Updated');
    }

    public function cartProductDelete(Request $request)
    {
        $rules=[
            'product_id' => 'required|exists:products,id|integer',
        ];
        $request->validate($rules);
        $user_id = Auth::user()->id;
        $user = User::find($user_id)->product()->detach($request->product_id);
        // return $request;
        return redirect()->back()->with('Success', 'Your Cart Has Been Updated');
    }

    public function cartTotal(){
        // $products=
        $user_id = Auth::user()->id;
        // return $user_id;
        $user = User::find($user_id);
        $products = $user->product;
        $i=0;
        foreach ($products as $product){
            $productPrice[$i]= ($product->pivot->quantity)*($product->price);
            $i++;
        }
        return view('front.cart-total',compact('products','productPrice'));
    }
}
