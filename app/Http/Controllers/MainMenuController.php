<?php

namespace App\Http\Controllers;

use App\Models\MainMenu;
use Exception;
use Illuminate\Http\Request;

class MainMenuController extends Controller
{
    //
    public function create(Request $request)
    {
        try {
            return  response(MainMenu::create(["payload" => json_encode($request->all())]), 201);
        } catch (Exception $e) {
            return response($e->getMessage(), 400);
        }
    }

    public function read(MainMenu $mainMenu, Request $request)
    {
        dd($mainMenu);
        if ($mainMenu->isNotEmpty()) {
            return response($mainMenu, 200);
        } else {
            return response(MainMenu::paginate(), 200);
        }
    }
}
