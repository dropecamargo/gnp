<?php

/**
* Agregamos un cliente nuevo a la base de datos.
*/
class CustomerTableSeeder extends Seeder {
    public function run(){
        Customer::create(array(
            'cedula'   => '1023878024',
            'nombre'   => 'PEDRO ANTONIO CAMARGO JIMENEZ',
            'direccion_casa' => 'Cra 68I # 31-66',
            'barrio_casa' => 'Floralia',
            'telefono_casa' => '3176826198',
            'empresa' => 'KOI-TI',
            'cargo' => 'Developer'                    
        ));
    }
}