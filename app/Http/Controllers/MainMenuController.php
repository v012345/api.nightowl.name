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
        echo $request->page;
        return MainMenu::all();

        if ($mainMenu) {
            return response($mainMenu, 200);
        } else {
            return MainMenu::all();
            return response(MainMenu::paginate($request->page), 200);
        }
    }
}
