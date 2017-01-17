<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('questions', function (Blueprint $table) {
			 $table->increments('id')->unsigned();
			 $table->integer('survey_id')->unsigned();
			 $table->foreign('survey_id')->references('id')->on('surverys');
			 $table->text('question_text');
			 $table->enum('question_type',['text','textarea','radio','checkbox','dropdown']);
			 $table->boolean('question_required')->default('0');
			 $table->boolean('question_enabled')->default('1');
			 $table->string('question_dimension','255');
			 $table->tinyInteger('display_order');
		 });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('questions');
    }
}
