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
        if ($mainMenu->exists) {
            return response($mainMenu, 200);
        } else {
            return response(MainMenu::paginate($request->per_page ?? 10), 200);
        }
    }

    public function delete(MainMenu $mainMenu)
    {
        $mainMenu->delete();
        return response("", 204);
    }

    public function update(MainMenu $mainMenu, Request $request)
    {
        $mainMenu->payload = json_encode($request->all());
        $mainMenu->save();
        return response("", 200);
    }
}
