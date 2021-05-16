<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\Region;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\traits\generalTrait;


class UserController extends Controller
{
    //
    use generalTrait;

    public function show(){
        $users = User::get();
        return view('admin.user.show-users', compact('users'));
    }
    public function create(){
        return view('admin.user.create-user');
    }
    public function store(Request $request){
        $rules=[
            "name"=>"required|max:25",
            "email"=>"required|email|unique:users,email",
            "password"=>"required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
            "code"=>"required|integer",
            "status"=>"required|integer",
            "phone"=>"numeric|digits:11|unique:users,phone",
            "photo"=>"mimes:jpeg,jpg,png",
        ];
        $request->validate($rules);
        $data=$request->except('_token','password','photo');
        $data['password']=Hash::make($request->password);
        $data['email_verified_at']= Carbon::now()->toDateTimeString();
        if($request->photo){
            $imageName= $this->UploadPhoto($request->photo , 'user');
            $data['photo']=$imageName;
        }
        else{
            $data['photo']="default.png";
        }
        User::insert($data);
        return redirect('admin/user/show')->with('Success','The User has been added successfully');
    }
    public function edit($id){
        $user=User::find($id);
        return view('admin.user.edit-user' ,compact('user'));
    }

    public function update(Request $request , $id){
        // return $request;
        $rules=[
            "name"=>"required|max:25",
            "email"=>"required|email",
            // "password"=>"min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
            "code"=>"required|integer",
            "status"=>"required|integer",
            "phone"=>"numeric|digits:11",
            "photo"=>'image|mimes:png,jpg,jepg|max:1024',
        ];
        $request->validate($rules);
        $data=$request->except('_token','photo','password');
        if($request->has('photo')){
            $imageName= $this->UploadPhoto($request->photo , 'user');
            $data=$request->except('photo','_token','_method');
            $data['photo']=$imageName;
        }
        if($request->has('password')){
            $data['password']=Hash::make($request->password);
        }else{
            $data['password']=User::select('password')->find($id);
        }
        // return $data;
        $update=User::where('id','=', $id)->update($data);
        return redirect('admin/user/show')->with('Success','The User has been updated successfully');

    }

    public function delete(Request $request){
        $rule=[
            "id"=>'required|exists:users,id|integer'
        ];
        $request->validate($rule);
        if($request->photo!='default.png'){
            $photoPath=public_path("images\user\\" . $request->photo);
            if(file_exists($photoPath)){
            unlink($photoPath);
            }
        }
        User::destroy($request->id);
        return redirect()->back()->with('Success','the user has been deleted successfully');

    }
    public function userOrder($id)
    {
        $user_orders=Order::where('user_id','=',$id)->get();
        // return $user_orders;
        // foreach ($user_orders as $o) {
        //     return Address::find($o->address_id);
        // }
        $user=User::get();
        $addresses=Address::get();
        $regions=Region::get();
        return view('admin.user.show-user-orders',compact('user_orders','user','addresses','regions'));
    }


}
