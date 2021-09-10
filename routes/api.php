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
    
    Route::prefix('user')->group(function () {
        Route::post('signup', [UsersController::class, 'signup']);
        Route::post('profile', [UsersController::class, 'profile']);
        Route::post('profile/set', [UsersController::class, 'profileSet']);
        Route::post('orders', [UsersController::class, 'orders']);
    });
});
