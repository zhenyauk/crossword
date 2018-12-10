<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();


            $table->string('level_points')->nullable();
            $table->string('experience_points')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('avatar')->nullable();
            $table->integer('online')->nullable();
            $table->dateTime('last_active')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('befriend_token')->nullable();
            $table->string('apn_token')->nullable();
            $table->string('gcm_token')->nullable();

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
        Schema::dropIfExists('users');
    }
}
