<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recibos',function($table){
			$table->engine = 'InnoDB';
            $table->increments('id');   
            $table->integer('numero')->unsigned()->unique();
            $table->integer('contrato')->unsigned();
            $table->integer('cobrador')->unsigned();
            $table->date('fecha');
            $table->string('tipo', 2);
            $table->float('valor');           	
			$table->timestamps();

        	$table->foreign('contrato')->references('id')->on('contratos')->onDelete('restrict');
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
		Schema::drop('recibos');
	}
}
