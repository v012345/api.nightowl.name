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

    // Log::debug($request);

    $x_hub_signature_256 = $request->header("x-hub-signature-256");
    Log::debug($x_hub_signature_256);
    $signature = hash_hmac("sha256", $request->getContent(), "56cbb2381a1b95c66c2e28ae65bbe9b251a76c88");
    Log::debug($signature);
    if (hash_equals($x_hub_signature_256, $signature)) {
        Log::debug("equals");
    } else {
        Log::debug("<><><><><><><><>");
    }
});


//bbbbbbbbbbbbbbbbbbbbbbbb
//cccccccccccccccccc