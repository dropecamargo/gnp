<?php

/**
* Agregamos un usuario nuevo a la base de datos.
*/
class UserTableSeeder extends Seeder {
    public function run(){
        User::create(array(
            'users_cuenta'   => 'admin',
            'users_email'    => 'dropecamargo@gmail.com',
            'users_nombre'   => 'Administrator',
			'users_nivel'   => '0',
            'users_password' => Hash::make('admin') 
            // Hash::make() nos va generar una cadena con nuestra contraseña encriptada
        ));
    }
}