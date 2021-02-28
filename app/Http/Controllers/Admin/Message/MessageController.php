<?php

namespace App\Http\Controllers\Admin\Message;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    //
    public function showMessage()
    {
        $messages=Message::get();
        return view('admin.messages.show-messages',compact('messages'));
    }
    public function delete(Request $request)
    {
       $rule=[
        "id"=>'required|exists:messages,id|integer'
    ];
    $request->validate($rule);
    Message::destroy($request->id);
    return redirect()->back()->with('Success','The Message Has Been Deleted');
    }
    public function update($id,$action)
    {
       $message=Message::where('id','=',$id)->first();
       //change th status of message according to the action
       $message->status=$action;
       $message->save();
       return redirect()->back()->with('Success','The Message\'s Status Has Been updated');
    }
}
