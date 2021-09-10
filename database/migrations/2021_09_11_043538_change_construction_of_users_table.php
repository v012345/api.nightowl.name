<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeConstructionOfUsersTable extends Migration
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
            $table->string('avatar')->nullable();
            $table->string("country_code")->nullable(false)->default("86");
            $table->string('phone_number')->unique()->index();
            $table->string('verifying_code', 4)->nullable(false);
            $table->string('email')->index()->nullable()->change();
            $table->boolean("remember_token")->default(true)->change();
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
            $table->dropColumn('avatar');
            $table->dropColumn('country_code');
            $table->dropColumn("phone_number");
            $table->dropColumn("verifying_code");
            $table->string('email')->unique()->change();
            $table->rememberToken()->change();
        });
    }
}
