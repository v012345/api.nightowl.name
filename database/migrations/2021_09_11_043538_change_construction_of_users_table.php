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
            // $table->string("country_code", 10)->default("86");
            $table->string("account")->nullable()->unique()->index();
            $table->string('phone_number')->unique()->index();
            $table->string('email')->index()->change();
            $table->boolean("admin")->nullable(false)->default(false);
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
            $table->dropColumn("account");
            // $table->dropColumn('country_code');
            $table->dropColumn("phone_number");
            $table->dropIndex(["email"]);
            // $table->string('email')->nullable(false)->change();
            // $table->rememberToken()->default(null)->change();
        });
    }
}
