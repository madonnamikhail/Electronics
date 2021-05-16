<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function dashboard(){

        // 1-make your role
        // $role = Role::create(['name' => 'Secondwriter']);
        // 2-make your permission
        // $permission = Permission::create(['name' => 'third edit articles']);
        // 3-find role and permission according to their id;
        // $role=Role::find(15);
        // $permission=Permission::find(78);
        // 4-assign permission to a role will find it in role_has permission table
        // $role->givePermissionTo($permission);
        // 5-assgin the model with the permssiion and thr role will find it in 2 tables (model_has role & model_has_permission)
        // auth()->user()->assignRole('Secondwriter');
        // auth()->user()->givePermissionTo('third edit articles');

        // return auth()->user()->assignRole('Secondwriter');


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


    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/admin/admin');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
    protected function loggedOut(Request $request)
    {
        //
    }

}
