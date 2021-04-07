<?php

namespace App\Http\Controllers\SupplierDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierDashoardController extends Controller
{
    public function supplierLoginForm()
    {
        return view('auth.supplierlogin');
    }
    public function supplierLogin(Request $request)
    {
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required|min:6',
        ]);
        // return $request;
        $remember_me= $request->has('remember') ? true : false ;
        if(auth()->guard('supplier')->attempt(['email'=>$request->email , 'password' =>$request->password])){
            return redirect()->intended('/supplier/supplier');
        }
        return back()->withInput($request->only('email'));
    }

    public function index()
    {
        return view('supplier.supplierindex');
    }
}
