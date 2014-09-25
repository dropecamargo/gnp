<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usuario', function($table)
        {    
		    $table->increments('id');
            $table->string('usuario_cuenta', 20);
            $table->string('usuario_nombre', 100);
            $table->string('usuario_perfil', 1);
            $table->text('usuario_clave');
			$table->boolean('usuario_activo', 2);
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
		Schema::drop('usuario');
	}

}
