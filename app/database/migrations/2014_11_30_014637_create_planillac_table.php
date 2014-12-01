<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanillacTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('planillac',function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
            $table->integer('planilla')->unsigned();
            $table->integer('contrato')->unsigned();
            $table->timestamps();
          	
        	$table->foreign('contrato')->references('id')->on('contratos')->onDelete('restrict');        	           	
        	$table->foreign('planilla')->references('id')->on('planilla')->onDelete('restrict');        	           	
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('planillac');
	}

}
