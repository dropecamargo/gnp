<?php

class Bitacora extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'bitacora';

    public static function launch($tabla, $llave, $campo, $anterior, $nuevo)
    {
        $bitacora = new Bitacora();
        $bitacora->tabla = $tabla;
        $bitacora->llave = $llave;
        $bitacora->campo = $campo;
        $bitacora->anterior = $anterior;
        $bitacora->nuevo = $nuevo;
        $bitacora->usuario = Auth::user()->id;
        $bitacora->save();
    }
}