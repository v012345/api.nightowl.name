<?php

use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
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

Route::post('/test', function (Request $request) {
    // return view('welcome');
    // return $request->method();
    return array("code" => 400, "status" => "OK");
});

Route::prefix('vue3learning/v1')->group(function () {
    Route::prefix('user')->middleware(["DecryptUserInfo", "ValidateUserInfo", "EncryptUserInfo"])->group(function () {
        Route::post('signup/verify', [UsersController::class, 'verify'])->withoutMiddleware(["DecryptUserInfo", "ValidateUserInfo"]);
        Route::post('signup', [UsersController::class, 'signup'])->withoutMiddleware(["ValidateUserInfo"]);
        Route::post('login', [UsersController::class, "login"])->withoutMiddleware(["DecryptUserInfo", "ValidateUserInfo"]);
        Route::post("logout", [UsersController::class, "logout"])->withoutMiddleware(["EncryptUserInfo"]);
        Route::post("delete", [UsersController::class, "delete"])->withoutMiddleware(["EncryptUserInfo"]);
        Route::post('profile', [UsersController::class, 'profile']);
        Route::post('set/profile', [UsersController::class, 'setProfile']);
        Route::post('orders', [UsersController::class, 'orders']);
    });
});

Route::prefix('vue3learning/v1')->group(function () {
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
});
