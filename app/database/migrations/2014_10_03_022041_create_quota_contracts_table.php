<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotaContractsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cuotas',function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
            $table->integer('contrato')->unsigned();
            $table->integer('cuota')->unsigned();
            $table->date('fecha');
           	$table->float('valor');
          	$table->float('saldo');
          	$table->timestamps();
          	
        	$table->foreign('contrato')->references('id')->on('contratos')->onDelete('restrict');        	           	
 			$table->unique(array('contrato', 'cuota'));       
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cuotas');
	}

}
