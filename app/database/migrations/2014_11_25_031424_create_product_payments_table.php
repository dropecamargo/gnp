<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recibop',function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
            $table->integer('recibo')->unsigned();
            $table->integer('producto')->unsigned();
            $table->integer('devolucion');
          	$table->timestamps();
          	
        	$table->foreign('recibo')->references('id')->on('recibos')->onDelete('restrict');        	           	
 			$table->foreign('producto')->references('id')->on('productos')->onDelete('restrict');       
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('recibop');
	}

}
