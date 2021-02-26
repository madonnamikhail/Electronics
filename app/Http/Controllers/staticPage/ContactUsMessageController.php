<?php

namespace App\Http\Controllers\staticPage;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendContactUsMessage;

class ContactUsMessageController extends Controller
{
    public function message()
    {
        return view('staticPages.contactUs.contact-us');
    }

    public function insertMessage(Request $request)
    {
        // return $request;
        // check if user exists
        $email = $request->email;
        $exists = 0;
        $verified = 0;

        $check = User::where('email', '=', $email)->first();
        // return $check;
        if($check){
            $exists = 1;
            $user_verified = $check->email_verified_at;
            // $check->hasVerifiedEmail()
            if($user_verified){
                $verified = 1;
            }
        }
        // tzbitt l data
        $data = $request->except('_token');
        $data['user_exist'] = $exists;
        $data['verified'] = $verified;

        // insert
        $check_db = Message::insert($data);

        $message = Message::where('email', '=', $email)->first();
        $data['created_at'] = $message->created_at;
        // send mail
        // staticPages.contactUs.mail-contactUs
        $mail = "mennah555@gmail.com";
        $sendmail = new sendContactUsMessage($data);
        Mail::to($mail)->send($sendmail);

        return redirect()->back()->with('Success', 'Your Message Has Been Sent');
    }
}
