<?php

/**
* Agregamos un usuario nuevo a la base de datos.
*/
class EmployeeTableSeeder extends Seeder {
    public function run(){
        Employee::create(array(
            'cedula'   => '1023878024',
            'nombre'   => 'PEDRO CAMARGO',
            'cargo'   => 'V',
            'activo' => True                    
        ));
    }
}