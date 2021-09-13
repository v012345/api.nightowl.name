<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use stdClass;

class MessagesController extends Controller
{
    //
    public function sendVerificationCode(Request $request)
    {
        //do not verify the phone number
        //use event to send code
        if ($request->is("*/phone/send_verification_code")) {
            $to = $request->phone_number;
            $by = "phone";
        }
        if ($request->is("*/email/send_verification_code")) {
            $to = $request->email;
            $by = "email";
        }
        if (!$to)
            return array("code" => 400, "msg" => "Phone number or email adress is missing.");
        $verification_code =  random_int(1000, 9999);
        //event by to;
        Redis::setex($to, 60, $verification_code);
        return array("code" => 200, "msg" => "Has sent verification code.");
    }
    public function sendActivationToken(Request $request)
    {
        $activation_token =  new stdClass();
        $user = new stdClass();
        $user->id = $request->id;

        $to = $request->email ??  (User::find($request->id))->email;
        $redirectURL = $request->redirectURL ?? "https://www.google.com/";

        $activation_token->user = $user;
        $activation_token->email = $to;
        $activation_token->redirectURL = $redirectURL;
        $activation_token->created_at = date("Y-m-d H:i:s", time());
        $activation_token = Crypt::encrypt($activation_token);

        $view = 'email.activate';
        $subject = "Thanks for your register, please verify your email account first";

        try {
            Mail::send($view, compact('activation_token'), function ($message) use ($to, $subject) {
                $message->to($to)->subject($subject);
            });
        } catch (Exception $e) {

            return array("code" => 400, "msg" => "Time out");
        }
        return array("code" => 200, "msg" => "Sent successfully");
    }
}
