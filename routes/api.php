<?php

use App\Models\MainMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Nette\Utils\Json;

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



Route::post('test', function (Request $request) {
    return $request->all();
});

Route::prefix("v1")->group(function () {
    Route::prefix("backend")->group(function () {
        Route::post("main_menus", function (Request $request) {
            try {
                return  response(MainMenu::create(["payload1" => json_encode($request->all())]), 201);
            } catch (Exception $e) {
                return response($e->getMessage(), 400);
            }
        });
    });
});
