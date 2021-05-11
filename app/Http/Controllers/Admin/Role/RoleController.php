<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //
    public function show()
    {
        $roles=Role::all();
        return view('admin.roles.all-roles',compact('roles'));
    }
    public function create()
    {
        $guards=array_keys(config('auth.guards'));
        $permissions=Permission::all();
        return view('admin.roles.create-role',compact('guards','permissions'));
    }
    public function store(Request $request)
    {
        // return $request;
        $rules=[
            'name'=>['required','string'],
            'guard_name'=>['required']
            // 'permissions'
        ];
        $request->validate($rules);
        $role = Role::create($request->except('_token','permission_id'));
        $role->syncPermissions($request->permission_id);
        return redirect('all.roles')->with('Success','Role has been added successfully');
    }
    public function edit($id)
    {
        $role=Role::find($id);
        $guards=array_keys(config('auth.guards'));
        // $permissions=Permission::all();
        $permissions = auth()->user()->permissions;
        // return $permissions;
        return view('admin.roles.edit-role',compact('role','guards','permissions'));
    }
    public function update(Request $request , $id)
    {
        return $request;
    }

}
