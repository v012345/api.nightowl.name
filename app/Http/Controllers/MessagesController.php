<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use stdClass;

class MessagesController extends Controller
{
    //
    public function sendVerifyingCode(Request $request)
    {
        //do not verify the phone number
        //use event to send code
        if (!$request->phone_number)
            return array("code" => 400, "msg" => "Phone number is missing.");
        $request->phone_number;
        Redis::setex($request->phone_number, 60, random_int(1000, 9999));
        return array("code" => 200, "msg" => "Has sent verifying code.");
    }
    public function sendEmail(Request $request)
    {
        $data =  new stdClass();
        $user = new stdClass();
        $user->id = $request->user->id;

        $to = $request->email ??  (User::find($request->user->id))->email;
        $redirectURL = $request->redirectURL ?? "www.googel.com";

        $data->user = $user;
        $data->email = $to;
        $data->redirectURL = $redirectURL;
        $data->created_at = date("Y-m-d H:i:s", time());
        $data = Crypt::encrypt($data);

        $view = 'email.verify';
        $from = 'v012345@163.com';
        $name = "Meteor";
        $subject = "Thanks for your register, please verify your email account first";
        Mail::send($view, compact('data'), function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
            // $message->from($from, $name);
            // $message->sender('john@johndoe.com', 'John Doe');
            // $message->to('john@johndoe.com', 'John Doe');
            // $message->cc('john@johndoe.com', 'John Doe');
            // $message->bcc('john@johndoe.com', 'John Doe');
            // $message->replyTo('john@johndoe.com', 'John Doe');
            // $message->subject('Subject');
            // $message->priority(3);
            // $message->attach('pathToFile');
        });
    }
}
