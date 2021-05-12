<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
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
        return redirect('admin/role/show')->with('Success','Role has been added successfully');
    }
    public function edit($id)
    {
        $role=Role::find($id);
        $guards=array_keys(config('auth.guards'));
        $all_permissions=Permission::all();
        return view('admin.roles.edit-role',compact('role','guards','all_permissions'));
    }
    public function update(Request $request , $id)
    {
        $rules=[
            'name'=>['required','string'],
            'guard_name'=>['required']
            // 'permissions'
        ];
        $request->validate($rules);
        $role = Role::find($id);
        $permissions = $request->permission_id;
        $role->syncPermissions($permissions);
        return redirect('admin/role/show')->with('Success','Role has been updated successfully');
    }
    public function delete(Request $request)
    {
        Role::destroy($request->id);
        return redirect('admin/role/show')->with('Success','Role has been deleted successfully');
    }
}
