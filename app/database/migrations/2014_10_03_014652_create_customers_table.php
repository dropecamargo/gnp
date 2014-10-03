<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clientes',function($table){
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('cedula',15)->unique();  
            $table->string('nombre',100);           
            $table->string('direccion_casa',100);
            $table->string('barrio_casa',50);
            $table->string('telefono_casa',20);
            $table->string('empresa',50);
            $table->string('cargo',20); 
            $table->string('direccion_empresa',100);
            $table->string('barrio_empresa',50);
            $table->string('telefono_empresa',20);
			$table->string('ref1_nombre',100);
            $table->string('ref1_parentesco',50);
            $table->string('ref1_direccion',100);
            $table->string('ref1_telefono',20);
            $table->string('ref2_nombre',100);
            $table->string('ref2_parentesco',50);
            $table->string('ref2_direccion',100);
            $table->string('ref2_telefono',20);
			$table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clientes');
	}

}
