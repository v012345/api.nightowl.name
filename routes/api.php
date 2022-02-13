<?php

use App\Http\Controllers\PayController;
use App\Http\Middleware\VerifySignature;
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


Route::post("hotfix", function (Request $request) {
    $x_hub_signature_256 = $request->header("x-hub-signature-256");
    $signature = "sha256=" . hash_hmac("sha256", $request->getContent(), config("github.secret"));
    if (hash_equals($x_hub_signature_256, $signature)) {
        echo shell_exec("bash " . base_path() . "/scripts/gitpull.sh " . base_path());
    }
});



Route::get('test', function (Request $request) {
    // return 12345;
    // Test::dispatch();
});

// Route::prefix("v1")->group(function () {
//     Route::prefix("backend")->group(function () {
//         Route::post("main-menus", [MainMenuController::class, "create"]);
//         Route::get("main-menus/{mainMenu?}", [MainMenuController::class, "read"]);
//         Route::delete("main-menus/{mainMenu}", [MainMenuController::class, "delete"]);
//         Route::put("main-menus/{mainMenu}", [MainMenuController::class, "update"]);
//     });
// });


Route::post("transfer", [PayController::class, "transfer"])->middleware(VerifySignature::class);
Route::get("4s/user/paid", [NotifyController::class, "notify4sUser"]);
