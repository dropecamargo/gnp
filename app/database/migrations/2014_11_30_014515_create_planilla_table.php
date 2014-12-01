<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanillaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('planilla',function($table){
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('zona',256);
            $table->integer('cobrador')->unsigned();
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('cobrador')->references('id')->on('empleados')->onDelete('restrict');        	           	
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('planilla');
	}

}
