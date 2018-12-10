<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChallengesUpdateFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('challeges', function (Blueprint $table) {
            $table->integer('winner_id')->nullable();

            //$table->integer('user_points')->nullable();
            $table->integer('user_help_used')->nullable();
            $table->integer('user_points')->nullable();

            //$table->integer('friend_points')->nullable();
            $table->integer('friend_help_used')->nullable();
            $table->integer('friend_points')->nullable();

            $table->integer('friend_notified')->nullable();
            $table->integer('accept_notified')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('challeges', function (Blueprint $table) {
            //
        });
    }
}
