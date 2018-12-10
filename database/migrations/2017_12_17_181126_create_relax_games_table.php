<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelaxGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relax_games', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('crossword_id')->unsigned()->index();
            $table->foreign('crossword_id')->references('id')->on('crosswords')->onDelete('cascade');

            $table->integer('elepsed_time')->nullable();
            $table->string('player_solution')->nullable();
            $table->integer('completed')->nullable();
            $table->integer('helps_left')->nullable();



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
        Schema::dropIfExists('relax_games');
    }
}
