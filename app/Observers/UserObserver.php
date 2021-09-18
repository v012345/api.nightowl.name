<?php

namespace App\Observers;

use App\Models\User;
use Faker\Generator;
use Illuminate\Support\Facades\Crypt;

class UserObserver
{
    //
    public function creating(User $user)
    {

        // $user->email  =  $user->email ?? $user->phone_number . "@" . config("app.name") . ".com";
        // $user->account  =  $user->account ?? $user->phone_number;
        $user->password = $user->password ? bcrypt($user->password) : null;
        // $user->
    }
}
