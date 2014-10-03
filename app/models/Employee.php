<?php

class Employee extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'empleados';

	protected $perPage = 6;

	protected $fillable = array('cedula', 'nombre', 'cargo', 'activo');

	public $errors;

	public $states = array('0' => 'Inactivo', '1' => 'Activo');

	public $jobs = array('C' => 'Cobrador', 'V' => 'Vendedor');

	public function isValid($data)
    {
        $rules = array(            
            'cedula' => 'required|min:5|max:15|unique:empleados',            
            'nombre' => 'required|min:4|max:100'
        );
        
        if ($this->exists){
			$rules['cedula'] .= ',cedula,' . $this->id;
        }else{
			$rules['cedula'] .= '|required';
        }
        
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
