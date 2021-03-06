<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contratos',function($table){
			$table->engine = 'InnoDB';
            $table->increments('id');   
            $table->integer('numero')->unsigned()->unique();
            $table->integer('cliente')->unsigned();
            $table->integer('vendedor')->unsigned();
            $table->date('fecha');
           	$table->float('valor');
           	$table->integer('cuotas');
           	$table->integer('periodicidad');
           	$table->date('primera');           	
			$table->timestamps();

        	$table->foreign('cliente')->references('id')->on('clientes')->onDelete('restrict');
        	$table->foreign('vendedor')->references('id')->on('empleados')->onDelete('restrict');        	           	
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contratos');
	}

}
