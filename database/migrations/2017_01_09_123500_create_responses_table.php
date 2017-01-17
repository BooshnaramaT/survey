<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
			 $table->increments('id')->unsigned();
			 
			$table->integer('user_survey_id')->unsigned();      
			$table->foreign('user_survey_id')->references('id')->on('user_survey');
			
			$table->integer('question_id')->unsigned();      
			$table->foreign('question_id')->references('id')->on('questions');
			
			$table->integer('option_id')->unsigned();      
			$table->foreign('option_id')->references('id')->on('options');
						 
			$table->text('text_response');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('responses');
    }
}
