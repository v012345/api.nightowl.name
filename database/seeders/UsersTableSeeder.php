<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::factory()->count(5)->create();
        $user = User::find(1);
        $user->phone_number = '15521224344';
        $user->email = "v012345@163.com";
        $user->admin = true;
        $user->save();
    }
}
