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
        Reply::factory()->times(10000)->create();
        Reply::factory()->times(10000)->create();
        Reply::factory()->times(10000)->create();
        Reply::factory()->times(10000)->create();
        Reply::factory()->times(10000)->create();
        Reply::factory()->times(10000)->create();
        Reply::factory()->times(10000)->create();
        Reply::factory()->times(10000)->create();
        Reply::factory()->times(10000)->create();
        Reply::factory()->times(10000)->create();
    }
}
