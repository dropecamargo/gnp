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

    public static function getData()
    {
        $query = Customer::query();      
        $query->select('clientes.*');        
        if (Input::has("cliente_cedula")) {
            $query->where('clientes.cedula', Input::get("cliente_cedula"));
        }
        if (Input::has("cliente_nombre")) {          
            $query->where('clientes.nombre', 'like', '%'.Input::get("cliente_nombre").'%');
        }        
        $query->orderby('clientes.nombre', 'ASC');
        return $query->paginate();
    }

    public function setNombreAttribute($name){
		$this->attributes['nombre'] = strtoupper($name);
	}

    public function setDireccioncasaAttribute($direccion_casa){
        $this->attributes['direccion_casa'] = strtoupper($direccion_casa);
    }

    public function setBarriocasaAttribute($barrio_casa){
        $this->attributes['barrio_casa'] = strtoupper($barrio_casa);
    }

    public function setEmpresaAttribute($empresa){
        $this->attributes['empresa'] = strtoupper($empresa);
    }

    public function setCargoAttribute($cargo){
        $this->attributes['cargo'] = strtoupper($cargo);
    }

    public function setDireccionempresaAttribute($direccion_empresa){
        $this->attributes['direccion_empresa'] = strtoupper($direccion_empresa);
    }

    public function setBarrioempresaAttribute($barrio_empresa){
        $this->attributes['barrio_empresa'] = strtoupper($barrio_empresa);
    }

    public function setref1NombreAttribute($ref1_nombre){
        $this->attributes['ref1_nombre'] = strtoupper($ref1_nombre);
    }

    public function setRef1ParentescoAttribute($ref1_parentesco){
        $this->attributes['ref1_parentesco'] = strtoupper($ref1_parentesco);
    }

    public function setRef1direccionAttribute($ref1_direccion){
        $this->attributes['ref1_direccion'] = strtoupper($ref1_direccion);
    }

    public function setref2NombreAttribute($ref2_nombre){
        $this->attributes['ref2_nombre'] = strtoupper($ref2_nombre);
    }

    public function setRef2ParentescoAttribute($ref2_parentesco){
        $this->attributes['ref2_parentesco'] = strtoupper($ref2_parentesco);
    }

    public function setRef2direccionAttribute($ref2_direccion){
        $this->attributes['ref2_direccion'] = strtoupper($ref2_direccion);
    }
}