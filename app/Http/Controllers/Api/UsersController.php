<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{
    //
    public function store(UserRequest $request)
    {
        $verificationData = Cache::get($request->verification_key);
        if (!$verificationData) {
            // abort(403, "Verification code has expired");
            return response(["message" => "Verification code has expired"], 403);
        }

        if (!hash_equals($verificationData["verification_code"], $request->verification_code)) {
            // throw new AuthenticationException("Verification code is wrong");
            return response(["message" => "Verification code is wrong"], 403);
        }

        $user = User::create([
            // 'name' => $request->name ?? null,
            'phone_number' => $verificationData["phone_number"],
            // "password" => $request->password ?? null,
        ]);

        Cache::forget($request->verification_key);

        return new UserResource($user);
    }
}
