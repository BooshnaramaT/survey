<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		 Schema::create('options', function (Blueprint $table) {
        $table->increments('id')->unsigned();
        $table->text('option_text');
        $table->tinyInteger('option_weight');
        $table->integer('question_id')->unsigned();      
        $table->foreign('question_id')->references('id')->on('questions');
	});
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('options');
    }
}
