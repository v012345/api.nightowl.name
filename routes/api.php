<?php

use App\Events\Verify;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\UsersController;
use App\Jobs\TranslateSlug;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use Faker\Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
        Route::post('dynamic', [UsersController::class, "dynamic"]);
        Route::prefix("blog")->group(function () {
            Route::post('post', [BlogsController::class, "post"]);
            Route::post('delete', [BlogsController::class, "delete"]);
        });
    });

    Route::prefix("topic")->group(
        function () {
            Route::post("index", [TopicsController::class, "index"]);
            Route::post("create", [TopicsController::class, "create"]);
            Route::post("upload_images", [TopicsController::class, "uploadImage"]);
            Route::post("edit", [TopicsController::class, "edit"]);
            Route::post("delete", [TopicsController::class, "delete"]);
        }
    );

    Route::prefix("notification")->group(
        function () {
            Route::post("read", [NotificationsController::class, "read"]);
        }
    );

    Route::prefix("reply")->group(
        function () {
            Route::post("create", [RepliesController::class, "create"]);
            Route::post("delete", [RepliesController::class, "delete"]);
        }
    );

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
        // return gettype(User::all());
        // $users = User::all();
        // $user = $users->first();
        // $user_id = $user->id;

        // // 获取去除掉 ID 为 1 的所有用户 ID 数组
        // $followers = $users->slice(1);
        // $follower_ids = $followers->pluck('id')->toArray();

        // // 关注除了 1 号用户以外的所有用户
        // $user->follow($follower_ids);

        // // 除了 1 号用户以外的所有用户都来关注 1 号用户
        // foreach ($followers as $follower) {
        //     $follower->follow($user_id);
        // }
        //    event(new Verify()); 
        // $func = new ReflectionClass('Google_Service_Drive');
        // echo    $func->getFileName();
        // dd(json_decode(null, true));
        // dd(config("google"));
        // dd(Google_Service_Drive::DRIVE);
        // dd($request->all());
        // User::truncate();
        //    return app(Generator::class)->imageUrl();
        // return 0;
        // return User::where("id", 1)->first();
        // return Topic::orderWith("updated_at")->get();
        // $user =  User::find(1);
        // return Str::slug("aaaaa aefe ef fae f<fes> es<script>faed</ script>www");
        // return $user->blogs()->paginate(3);
        // $topic = Topic::find(2);
        // dispatch(new TranslateSlug($topic));
        // $user = User::find(1);
        // $user->topics();
        // return $user;
        // $topics=$user->topics()->get();
        // // dd($user->topics()->get()== $user->topics);
        // // dd($topics);
        // foreach($topics as $topic){
        //     dd($topic->replies());
        // }
        // dd($user->topics()->reply_count == $user->topics->reply_count);
        // $reply = Reply::find(3);
        // // $reply->topic()->first()->reply_count=20;
        // $topic =  $reply->topic()->first();
        // // dd($topic);
        // $topic->reply_count=20;
        // $topic->save();
        // $reply->topic->reply_count = 20;
        // $reply->save();
        // dump($reply->topic()->first()->reply_count, $reply->topic->reply_count);

        // return $reply->topic() == $reply->topic;

        // return $user->paginate(2)->appends("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");
        dd(url('12'), url()->current(), url()->full(), url()->previous());
        // $user = User::find(9);
        // $user->notifications->paginate(2);
        // return $user;
    });
});
Route::get("google_access_token", function (Request $request) {
    Redis::setex("google_auth_code", 3600, $request->code);
    return 200;
});
