<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();
        $user->followings()->sync($follower_ids, false);
        foreach ($followers as $follower) {
            $follower->followings()->sync($user_id, false);
        }
    }
}
