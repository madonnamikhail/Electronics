<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class LoginController extends Controller
{
    //
    public function dashboard(){

        // $role = Role::create(['name' => 'writer']);
        // $permission = Permission::create(['name' => 'edit articles']);
        $role=Role::find(1);
        $permission=Permission::find(1);
        $role->givePermissionTo($permission);

        return view('admin.adminindex');
    }

    public function getLogin(){
        return view('auth.adminlogin');
    }

    public function Loggedin(Request $request){
        // return $request;
        $this->validate($request,
        [
            'email'=>'required|email',
            'password'=>'required|min:6',
        ]
        );
        $remember_me= $request->has('remember') ? true : false ;
    if(auth()->guard('admin')->attempt(['email'=>$request->email , 'password' =>$request->password])){
        return redirect()->intended('/admin/admin');
    }
    return back()->withInput($request->only('email'));

    }


}
