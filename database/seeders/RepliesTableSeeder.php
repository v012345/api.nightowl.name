<?php

namespace Database\Seeders;

use App\Models\Reply;
use Illuminate\Database\Seeder;

class RepliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Reply::factory()->times(100000)->create();
    }
}
