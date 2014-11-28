<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('auxiliarreporte',function($table){
			$table->engine = 'InnoDB';

			$table->string('cst1');
			$table->string('cst2');
			$table->string('cst3');
			$table->string('cst4');
			$table->string('cst5');

            $table->integer('cin1');
            $table->integer('cin2');
            $table->integer('cin3');
            $table->integer('cin4');
            $table->integer('cin5');  

            $table->float('cf1');
            $table->float('cf2');
            $table->float('cf3');
            $table->float('cf4');
            $table->float('cf5');
            $table->float('cf6');
            $table->float('cf7');
            $table->float('cf8');

           	$table->date('cdt1'); 
           	$table->date('cdt2'); 
           	$table->date('cdt3'); 
           	$table->date('cdt4'); 
           	$table->date('cdt5');        	      
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('auxiliarreporte');
	}

}
