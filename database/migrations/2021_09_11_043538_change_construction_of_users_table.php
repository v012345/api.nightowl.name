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
            $table->string('avatar')->default("https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg")->comment("google copyright");
            $table->string("country_code", 10)->default("86");
            $table->string('phone_number')->unique()->index();
            $table->string('verifying_code', 4)->default("0000");
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
            $table->dropIndex(["email"]);
            $table->string('email')->nullable(false)->change();
            $table->rememberToken()->change();
        });
    }
}
