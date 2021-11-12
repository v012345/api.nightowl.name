<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

Route::get("{any}", function (Request $request) {
    return "@@@@@@@" . $request->path();
})->where('any', '.*');

Route::post("hotfix", function (Request $request) {
    Log::debug("-------------------------");
    Log::debug($request->header());
    Log::debug($request);
});


//bbbbbbbbbbbbbbbbbbbbbbbb
//cccccccccccccccccc