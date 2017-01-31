<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurverysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surverys', function (Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('title');
			$table->string('url','50');
			$table->string('logo','100');
			$table->integer('survey_theme_id')->unsigned();
			$table->foreign('survey_theme_id')->references('id')->on('themes');
			$table->dateTime('start_date');
			$table->dateTime('end_date');
			$table->boolean('open_survey_flag')->default('0');
			
			
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('surverys');
    }
}
