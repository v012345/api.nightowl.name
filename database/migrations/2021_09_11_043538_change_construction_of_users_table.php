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
            $table->string("name")->nullable()->change();
            $table->string('avatar')->nullable();
            $table->string("account")->nullable()->unique()->index();
            $table->string('phone_number')->unique()->nullable()->index()->after("name");
            $table->string('email')->change()->index()->nullable();
            $table->string('introduction')->nullable();
            $table->integer('notification_count')->nullable()->unsigned()->default(0);
            $table->timestamp("last_actived_at")->nullable();
            $table->string("password")->change()->nullable();
            $table->unsignedBigInteger("follower_count")->nullable()->default(0);
            $table->unsignedBigInteger("following_count")->nullable()->default(0);
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
            $table->dropColumn("phone_number");
            $table->dropIndex(["email"]);
            $table->dropColumn('introduction');
            $table->dropColumn("notification_count");
            $table->dropColumn("last_actived_at");
            $table->string("email")->nullable(false)->change();
            $table->string("password")->change()->nullable(false);
            $table->dropColumn("follower_count");
            $table->dropColumn("following_count");
            $table->string("name")->nullable(false)->change();
        });
    }
}
