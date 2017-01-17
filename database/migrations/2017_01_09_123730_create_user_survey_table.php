<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('user_survey', function (Blueprint $table) {
		   $table->increments('id')->unsigned();
		    $table->integer('survey_id')->unsigned();      
			$table->foreign('survey_id')->references('id')->on('surverys');
			
		    $table->integer('user_id')->unsigned();      
			$table->foreign('user_id')->references('id')->on('users');
			
		   $table->tinyInteger('survey_status');
		   $table->dateTime('notify_email_date');
		   $table->dateTime('reminder_email_date');
		   $table->dateTime('last_submitted_date');
	   });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
