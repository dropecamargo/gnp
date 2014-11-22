<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductContractsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contratop',function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
            $table->integer('contrato')->unsigned();
            $table->integer('producto')->unsigned();
            $table->integer('cantidad');
            $table->integer('devolucion');
          	$table->timestamps();
          	
        	$table->foreign('contrato')->references('id')->on('contratos')->onDelete('restrict');        	           	
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
		Schema::drop('contratop');
	}

}