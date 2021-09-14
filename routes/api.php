<?php

use App\Http\Controllers\BlogsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\UsersController;
use App\Models\User;
use Faker\Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('vue3learning/v2')->group(function () {
    Route::post('users', [UsersController::class, 'all']);
    Route::prefix('user')->group(function () {
        Route::post('signup', [UsersController::class, 'signup']);
        Route::post('login', [UsersController::class, 'login']);
        Route::post('logout', [UsersController::class, 'logout']);
        Route::post('update', [UsersController::class, 'update']);
        Route::post('delete', [UsersController::class, 'delete']);
        Route::post('detail', [UsersController::class, 'detail']);
        Route::post('reset/password', [UsersController::class, 'resetPassword']);
        Route::get('activate/email/{activation_token}', [UsersController::class, 'activateEmail'])->name("activate_email");
        Route::post('followers', [UsersController::class, "followers"]);
        Route::post('followings', [UsersController::class, "followings"]);
        Route::post('follow', [UsersController::class, "follow"]);
        Route::post('unfollow', [UsersController::class, "unfollow"]);
        Route::post('is_following', [UsersController::class, "isFollowing"]);
        Route::post('blogs', [UsersController::class, "blogs"]);
        Route::prefix("blog")->group(function () {
            Route::post('post', [BlogsController::class, "post"]);
            Route::post('delete', [BlogsController::class, "delete"]);
        });
    });

    Route::prefix('send')->group(function () {
        Route::post('email/activation_token', [MessagesController::class, 'sendActivationToken']);
        Route::post('phone/send_verification_code', [MessagesController::class, 'sendVerificationCode']);
        Route::post('email/send_verification_code', [MessagesController::class, 'sendVerificationCode']);
    });




    Route::any('/test', function (Request $request) {
        // return view('welcome');
        // return $request->method();
        // $user = new User();
        // dump($user);
        // $user->password = "123";
        // $user->name = "123";
        // $user->phone_number = "362qq781";
        // dump($user);
        // $user->save();
        // $user = User::create();
        // dump($user);
        // return array("code" => 200, "status" => "OK");
        // Redis::del("name");
        // return Redis::get("name");
        // return app(Faker\Generator::class)->emoji();
        // return redirect()->away("http://www.baidu.com");
        // return redirect("www.baidu.com",301);
        // return $i = 1;
        // return   $redirectURL = preg_replace_callback(["/^[^(https?:\/\/)].*/", "/(\/+)$/"], function ($matches) {
        //     dump($matches);
        //     if (isset($matches[1]))
        //         return "/";
        //     return "http://" . $matches[0] . "/";
        // }, $request->redirectURL);
        //    $redirectURL;

        // dd(app(Generator::class)->dateTime());

    });
});
