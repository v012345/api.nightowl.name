<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use stdClass;

class MessagesController extends Controller
{
    //
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
