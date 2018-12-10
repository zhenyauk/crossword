<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChallengeTemporariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenge_temporaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('challenge_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('opponent_id')->nullable();
            $table->integer('user_points')->nullable();
            $table->integer('user_time')->nullable();
            $table->integer('user_help_used')->nullable();
            $table->integer('winner_id')->nullable();

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
        Schema::dropIfExists('challenge_temporaries');
    }
}
