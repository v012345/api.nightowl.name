<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeEmailAndPhoneNumberOfUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            // $table->string("phone_number")->nullable()->after("name")->change();
            $table->string("phone_number")->nullable()->change();
            $table->string("email")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string("phone_number")->nullable(false)->change();
            $table->string("email")->nullable(false)->change();
        });
    }
}
