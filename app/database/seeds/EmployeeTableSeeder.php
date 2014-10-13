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

        Employee::create(array(
            'cedula'   => '79512780',
            'nombre'   => 'ALVARO FORERO',
            'cargo'   => 'C',
            'activo' => True                    
        ));
    }
}