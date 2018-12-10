<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrosswordDefinitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crossword_definitions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('crossword_id')->unsigned()->index();
            //$table->foreign('crossword_id')->references('id')->on('crosswords')->onDelete('cascade');
            $table->integer('revision')->nullable();
            $table->integer('positionX')->nullable();
            $table->integer('positionY')->nullable();
            $table->text('question')->nullable();
            $table->string('solution')->nullable();
            $table->string('definition_type')->nullable();
            $table->string('meta')->nullable();
            $table->integer('level')->nullable();
            $table->integer('sindex')->nullable();
            $table->boolean('horizontal')->default(true);
            $table->string('media_file_name')->nullable();
            $table->integer('media_file_size')->nullable();
            $table->integer('compleated')->default(0);
            $table->string('user_solution')->default(0);
            $table->string('media_content_type')->nullable();
            $table->dateTime('media_updated_at')->nullable();


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
        Schema::dropIfExists('crossword_definitions');
    }
}
