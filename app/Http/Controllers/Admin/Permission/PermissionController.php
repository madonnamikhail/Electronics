<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function show()
    {
        $permissions=Permission::all();
        return view('admin.permission.all-permissions',compact('permissions'));
    }
    public function create()
    {
        $guards=array_keys(config('auth.guards'));
        return view('admin.permission.create-permission',compact('guards'));
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
        $data = $request->except('_token');
        if($request->has('crud')){
            $data = [['name'=>'All '.$request->name,'guard_name'=>$request->guard_name],['name'=>'Add '.$request->name,'guard_name'=>$request->guard_name],['name'=>'Edit '.$request->name,'guard_name'=>$request->guard_name], ['name'=>'Delete '.$request->name,'guard_name'=>$request->guard_name]];
        }
        Permission::insert($data);
        return redirect('admin/permission/show')->with('Success','Permission has been added successfully');
    }
    public function edit($id)
    {
        $permission=Permission::find($id);
        $guards=array_keys(config('auth.guards'));
        return view('admin.permission.edit-permission',compact('permission','guards'));
    }
    public function update(Request $request , $id)
    {
        $rules=[
            'name'=>['required','string'],
            'guard_name'=>['required']
            // 'permissions'
        ];
        $request->validate($rules);
        $data = $request->except('_token');
        Permission::where('id','=',$id)->update($data);
        return redirect('admin/permission/show')->with('Success','Permission has been updated successfully');
    }
    public function delete(Request $request)
    {
        Permission::destroy($request->id);
        return redirect('admin/permission/show')->with('Success','Permission has been deleted successfully');
    }
}
