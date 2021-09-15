<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string("title")->index();
            $table->text("body");
            $table->unsignedBigInteger("user_id")->index();
            $table->unsignedInteger("category_id")->index();
            $table->unsignedBigInteger("relpy_count")->index()->default(0);
            $table->unsignedBigInteger("view_count")->index()->default(0);
            $table->unsignedBigInteger("last_reply_user_id")->nullable()->index();
            $table->unsignedBigInteger("order")->default(0);
            $table->text("excerpt")->nullable();
            $table->string("slug")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
