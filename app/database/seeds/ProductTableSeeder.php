<?php

/**
* Agregamos un usuario nuevo a la base de datos.
*/
class ProductTableSeeder extends Seeder {
    public function run(){
        Product::create(array(
            'nombre'   => 'Embrion de pato'      
        ));

        Product::create(array(
            'nombre'   => 'Omega 3'      
        ));

        Product::create(array(
            'nombre'   => 'Fibra natutal'      
        ));
    }
}