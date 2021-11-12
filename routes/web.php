<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("migrate", function (Request $request) {

    echo "bash " . base_path() . "/scripts/migrate.sh " . base_path() . "/artisan";
    echo shell_exec("bash " . base_path() . "/scripts/migrate.sh " . base_path() . "/artisan");
});
