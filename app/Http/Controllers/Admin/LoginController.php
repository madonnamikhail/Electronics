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
        // $role=Role::find(1);
        // $permission=Permission::find(1);
        // $role->givePermissionTo($permission);

        // $role = Role::create(['name' => 'SuperAdmin']);
        // $role = Role::create(['name' => 'UsersAdmin']);
        // $role = Role::create(['name' => 'DbAdmin']);
        // $role = Role::create(['name' => 'StaticPagesAdmin']);
        // $role = Role::create(['name' => 'RepoAndStatisticsAdmin']);
        // $role = Role::create(['name' => 'MessagesAdmin']);

        // $permission = Permission::create(['name' => 'Update User']);
        // $permission = Permission::create(['name' => 'Delete User']);
        // $permission = Permission::create(['name' => 'Create User']);
        // $permission = Permission::create(['name' => 'Show User']);

        // $permission = Permission::create(['name' => 'Update Database']);
        // $permission = Permission::create(['name' => 'Delete Database']);
        // $permission = Permission::create(['name' => 'Create Database']);
        // $permission = Permission::create(['name' => 'Show Database']);

        // $permission = Permission::create(['name' => 'Update StatisPages']);
        // $permission = Permission::create(['name' => 'Delete StatisPages']);
        // $permission = Permission::create(['name' => 'Create StatisPages']);
        // $permission = Permission::create(['name' => 'Show StatisPages']);

        // $permission = Permission::create(['name' => 'Update RepoAndStatistics']);
        // $permission = Permission::create(['name' => 'Delete RepoAndStatistics']);
        // $permission = Permission::create(['name' => 'Create RepoAndStatistics']);
        // $permission = Permission::create(['name' => 'Show RepoAndStatistics']);

        // $permission = Permission::create(['name' => 'Update Messages']);
        // $permission = Permission::create(['name' => 'Delete Messages']);
        // $permission = Permission::create(['name' => 'create Messages']);
        // $permission = Permission::create(['name' => 'Show Messages']);

        // $role = Role::find(1);
        // for($i=1; $i<=20; $i++){
        //     // echo($i);
        //     $permission = Permission::find($i);
        //     $role->givePermissionTo($permission);
        // }
        
        // return "m"; 

        // auth()->user()->assignRole('SuperAdmin');


        // $role = Role::create(['guard_name' => 'admin', 'name' => 'manager']);
        // $role = Role::find(8);
        // $permission = Permission::find(5);
        // $role->givePermissionTo($permission);
        // auth()->user()->assignRole('DbAdmin');
        // return Admin::permission('Update Database')->get();

        // auth()->user()->givePermissionTo('Update Database');
        // if(auth()->user()->hasRole('SuperAdmin')){
        //     return "ahaaa";
        // }else{
        //     return "aaaaaaaaaaaaaaaaaaaaaaaaa";
        // }
        // return auth()->user()->permissions;

        ///// work around
        // $flag =0;
        // $roles_of_currrent_admin = auth()->user()->roles;
        // foreach ($roles_of_currrent_admin as $role_of_currrent_admin) {
        //     if($role_of_currrent_admin->name == "SuperAdmin"){
        //         $flag = 1;
        //     }
        // }
        



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
