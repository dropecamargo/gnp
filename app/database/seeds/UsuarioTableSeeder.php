<?php

/**
* Agregamos un usuario nuevo a la base de datos.
*/
class UsuarioTableSeeder extends Seeder {
    public function run(){
        DB::table('usuario')->insert(array(
            'usuario_cuenta'    => 'admin',
            'usuario_nombre'    => 'Administrador',
			'usuario_clave'       => Hash::make('admin'),
			'usuario_activo'      => 'Si',
            'usuario_perfil'      => 'Administrador'
			
            
            // Hash::make() nos va generar una cadena con nuestra contraseña encriptada
        ));
    }
}

