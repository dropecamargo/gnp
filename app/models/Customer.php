<?php

class Customer extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'clientes';

	protected $perPage = 6;

	protected $fillable = array('cedula', 'nombre', 'direccion_casa', 'barrio_casa', 
		'telefono_casa', 'empresa', 'cargo', 'direccion_empresa', 'barrio_empresa', 
		'telefono_empresa', 'ref1_nombre', 'ref1_parentesco', 'ref1_direccion', 'ref1_telefono', 
		'ref2_nombre', 'ref2_parentesco', 'ref2_direccion', 'ref2_telefono');

	public $errors;

	public function isValid($data)
    {
        $rules = array(            
            'cedula' => 'required|min:5|max:15|regex:[^[0-9]*$]|unique:clientes',            
            'nombre' => 'required|min:4|max:100',
            'direccion_casa' => 'required|min:4|max:100',
            'barrio_casa' => 'required|min:2|max:50',
            'telefono_casa' => 'required|min:7|max:20',
            'empresa' => 'required|max:50',
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