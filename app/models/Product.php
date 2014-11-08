<?php

class product extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'productos';

	protected $perPage = 6;

	protected $fillable = array('nombre');

	public function isValid($data)
    {
        $rules = array(            
        	'nombre' => 'required|min:4|max:256'            
        );
        
        $validator = Validator::make($data, $rules);        
        if ($validator->passes()) {
            return true;
        }        
        $this->errors = $validator->errors();        
        return false;

    }

	public function setNombreAttribute($name){
		$this->attributes['nombre'] = strtoupper($name);
	}

	public static function getData()
    {
        $query = Product::query();      
        $query->select('productos.*');        
		if (Input::has("producto_nombre")) {          
            $query->where('productos.nombre', 'like', '%'.Input::get("producto_nombre").'%');
        } 
        $query->orderby('productos.nombre', 'ASC');
        return $query->paginate();
    }
}