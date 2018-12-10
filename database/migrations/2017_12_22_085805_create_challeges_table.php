<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChallegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challeges', function (Blueprint $table) {
            $table->increments('id');
           // $table->integer('challenge_id')->nullable();
            $table->integer('user_id')->unsigned()->index();
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('friend_id')->nullable();
            $table->integer('crossword_id')->nullable();
            $table->string('additonal')->nullable();
            $table->integer('is_active')->nullable();
           // $table->integer('accept_time')->default(30);
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
        Schema::dropIfExists('challeges');
    }
}
