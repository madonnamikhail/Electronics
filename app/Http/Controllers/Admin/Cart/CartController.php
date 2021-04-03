<?php

namespace App\Http\Controllers\Admin\Cart;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\User;
use Hamcrest\Core\IsNot;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function allCarts()
    {
        $user_carts = User::whereHas('product', function($q){
            $q->where('product_id','!=' ,Null);
        })->get();
        return view('admin.cart.all-user-cart', compact('user_carts'));
    }

    public function showCart($id)
    {
        $products = Product::with('user')->get();//find('id', '=', $id);
        foreach ($products as $product) {
            $users = $product->user;
            foreach ($users as $user) {
                $user_id[] = $user->id."<br>";
            }
        }
        return $user_id;
    }
}
