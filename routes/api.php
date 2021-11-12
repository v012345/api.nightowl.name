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


Route::post("hotfix", function (Request $request) {
    // Log::debug($request);
    $x_hub_signature_256 = $request->header("x-hub-signature-256");
    $signature = "sha256=" . hash_hmac("sha256", $request->getContent(), config("github.secret"));
    if (hash_equals($x_hub_signature_256, $signature)) {
        //通过验签
        Log::debug(shell_exec("git -C " . base_path() . " pull origin master"));
    }
});

Route::get("test", function (Request $request) {
    echo shell_exec("whoami");
    echo shell_exec("pwd");
    // echo "git -C " . base_path() . " pull origin master";
    echo "bash " . base_path() . "/scripts/gitpull.sh " . base_path();
    echo "<br>---";

    echo shell_exec("bash " . base_path() . "/scripts/gitpull.sh " . base_path());
});

//..
