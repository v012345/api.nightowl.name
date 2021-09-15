<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Category::insert([
            [
                "topic" => "share",
                "description" => "share and create",
            ],
            [
                "topic" => "tutorial",
                "description" => "teach and practice",
            ],
            [
                "topic" => "question",
                "description" => "question and answer",
            ],  [
                "topic" => "announcement",
                "description" => "website announcement",
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Category::truncate();
    }
}
