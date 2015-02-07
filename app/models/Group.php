<?php

class Group extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'grupos';

	protected $perPage = 6;

	protected $fillable = array('nombre', 'activo');

	public $errors;

	public $states = array('0' => 'Inactivo', '1' => 'Activo');

	public function isValid($data)
    {
        $rules = array(            
            'nombre' => 'required|min:2|max:200'
        );
        
        $validator = Validator::make($data, $rules);        
        if ($validator->passes()) {
            return true;
        }        
        $this->errors = $validator->errors();        
        return false;

    }

	public function validAndSave($data)
    {
        if ($this->isValid($data))
        {
            $this->fill($data);
            $this->save();            
            return true;
        }        
        return false;
    }

    public function setNombreAttribute($name){
        $this->attributes['nombre'] = strtoupper($name);
    }
}