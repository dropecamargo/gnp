<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empleados',function($table){
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('cedula',15)->unique();  
            $table->string('nombre',100);           
            $table->string('cargo', 1);
            $table->boolean('activo');            
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
		Schema::drop('empleados');
	}

}
