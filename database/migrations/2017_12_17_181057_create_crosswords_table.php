<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrosswordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crosswords', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('revision')->nullable();
            $table->text('content')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('level')->nullable();
            $table->boolean('published')->default(true);
            $table->dateTime('publish_on')->nullable();
            $table->integer('helps')->default(1);
            $table->integer('price')->default(0);
            $table->integer('difficulty_level')->nullable();
            $table->integer('goal_time')->nullable();
            $table->integer('locked_by')->nullable();
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
        Schema::dropIfExists('crosswords');
    }
}
