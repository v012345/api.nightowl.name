<?php

use App\Http\Controllers\MessagesController;
use App\Http\Controllers\UsersController;
use App\Models\User;
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

Route::get('/test', function (Request $request) {
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
    Redis::del("name");
    return Redis::get("name");
});

Route::prefix('vue3learning/v1')->group(function () {
    Route::middleware('token')->group(function () {
        Route::post('test', function () {
            return 123;
        })->withoutMiddleware(["VerifyToken"]);
    });
    Route::prefix('user')->middleware(["token", "ValidateUserInfo"])->group(function () {
        Route::post('signup/send_verifying_code', [UsersController::class, 'sendVerifyingCode'])->withoutMiddleware(["token", "ValidateUserInfo"]);
        Route::post('signup/confirm_verifying_code', [UsersController::class, 'confirmVerifyingCode'])->withoutMiddleware(["VerifyToken", "ValidateUserInfo"]);
        
        Route::get('verify/email/{verifying_code}/{redirectURL}', [UsersController::class, 'verifyEmail'])->name("verify_email");
        
        Route::post('login', [UsersController::class, "login"])->withoutMiddleware(["DecryptUserInfo", "ValidateUserInfo"]);
        Route::post("logout", [UsersController::class, "logout"])->withoutMiddleware(["EncryptUserInfo"]);
        Route::post("delete", [UsersController::class, "delete"])->withoutMiddleware(["EncryptUserInfo"]);
        Route::post('profile', [UsersController::class, 'profile']);
        Route::post('set/profile', [UsersController::class, 'setProfile']);
    });
    Route::prefix('get')->group(function () {
        Route::post('users', [UsersController::class, 'getAllUsers'])->middleware([\App\Http\Middleware\FormatPaginatedResults::class]);
        // Route::post('signup', [UsersController::class, 'signup']);
        // Route::post('login', [UsersController::class, "login"]);
        // Route::post("logout", [UsersController::class, "logout"]);
        // Route::post("delete", [UsersController::class, "delete"]);
        // Route::post('profile', [UsersController::class, 'profile']);
        // Route::post('set/profile', [UsersController::class, 'setProfile']);
        // Route::post('orders', [UsersController::class, 'orders']);
    });
    Route::prefix('sent')->middleware(["DecryptUserInfo", "ValidateUserInfo", "EncryptUserInfo"])->group(function () {
        Route::post('email/verify', [MessagesController::class, 'sendEmail']);
        // Route::post('signup', [UsersController::class, 'signup']);
        // Route::post('login', [UsersController::class, "login"]);
        // Route::post("logout", [UsersController::class, "logout"]);
        // Route::post("delete", [UsersController::class, "delete"]);
        // Route::post('profile', [UsersController::class, 'profile']);
        // Route::post('set/profile', [UsersController::class, 'setProfile']);
        // Route::post('orders', [UsersController::class, 'orders']);
    });
});

Route::prefix('vue3learning/v1')->group(function () {
});
