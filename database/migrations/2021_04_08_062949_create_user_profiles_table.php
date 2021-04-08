<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('uid')->unique()->comment('uid');
            $table->string('salt', 64)->unique();
            $table->timestamps();
        });

        \DB::statement("ALTER TABLE `user_profiles` comment '用户资料表'");
        \DB::statement('ALTER TABLE `user_profiles` MODIFY salt VARBINARY(64)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}
