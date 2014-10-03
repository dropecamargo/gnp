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
            $table->integer('contrato')->unsigned();
            $table->integer('cuota')->unsigned();
            $table->dateTime('fecha');
           	$table->float('valor');
          	$table->float('saldo');
			$table->timestamps();

        	$table->foreign('contrato')->references('id')->on('contratos')->onDelete('restrict');        	           	
 			$table->primary(array('contrato', 'cuota'));       
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
