<?php

namespace App\Http\Controllers\Admin\CrudAdmin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function show(){
        $admins=Admin::get();
        return view('admin.crudAdmin.all-admins' , compact('admins'));
    }

    public function create(){
        $roles = Role::get();
        $guards=array_keys(config('auth.guards'));
        return view('admin.crudAdmin.create-admin', compact('roles','guards'));
    }

    public function store(Request $request){
        $rules =[
            'name'=>'required|string',
            "email"=>"required|email|unique:users,email",
            "password"=>"required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
            "model_type"=>"required",
            "role_id"=>"required|exists:roles,id"
        ];
        $request->validate($rules);
        $data=$request->except('_token','password','model_type','role_id');
        $data['password']=Hash::make($request->password);
        Admin::insert($data);
        $model_id=Admin::latest('id')->first();
        $model_id->syncRoles($request->role_id);
        return redirect('admin/admin/show')->with('Success','The Admin has been added successfully with selected roles');
    }

    public function edit($id){
        $admin=Admin::find($id);
        $roles = Role::get();
        $rroles = new Role;
        $guards=array_keys(config('auth.guards'));
        return view('admin.crudAdmin.edit-admin' ,compact('rroles','admin','roles','guards'));
    }

    public function update(Request $request , $id){
        $rules=[
            "name"=>'required|string',
            "guard_name"=>'required|string',
            "role_id"=>'exists:roles,id|required',
        ];
        $request->validate($rules);
        $rule=[
            "id"=>'required|exists:admins,id|integer'
        ];
        $request->validate($rule);
        $model_id = Admin::find($id);
        $model_id->syncRoles($request->role_id);
        return redirect('admin/admin/show')->with('Success','The Admin has been Updated Successfully with selected roles');
    }

    public function delete(Request $request){
        $rule=[
            "id"=>'required|exists:admins,id|integer'
        ];
        $request->validate($rule);
        Admin::destroy($request->id);
        return redirect('admin/admin/show')->with('Success','The Admin has been Deleted Successfully with selected roles');
    }
}
