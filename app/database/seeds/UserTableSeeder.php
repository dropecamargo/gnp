<?php

/**
* Agregamos un usuario nuevo a la base de datos.
*/
class UserTableSeeder extends Seeder {
    public function run(){
        User::create(array(
            'username'   => 'admin',
            'email'    => 'dropecamargo@gmail.com',
            'name'   => 'Pedro Camargo',
            'password' => 'admin', 
			'activo' => True,
			'perfil'   => 'A'        
        ));
    }
}