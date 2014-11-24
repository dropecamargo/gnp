<?php

class Payment extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'recibos';

	public $types = array('PA' => 'Pago', 'DE' => 'Descuento', 'DV' => 'Devolución');

	protected $fillable = array('numero', 'fecha', 'contrato', 'cobrador', 'tipo', 'valor', 'proxima');

    public $errors;

    protected $perPage = 6;

	public function isValid($data)
    {
        $rules = array(            
            'numero' => 'required|min:1|max:10|unique:recibos|regex:[^[0-9]*$]',            
            'fecha' => 'required|date_format:Y-m-d',
            'contrato_numero' => 'required|min:1|max:10',
            'contrato' => 'required|numeric',
            'cobrador' => 'required|numeric|min:1',
            'valor' => 'required|min:1|regex:[^[0-9]*$]',
            'tipo' => 'required',
            'proxima' => 'date_format:Y-m-d'
        );
        
        if ($this->exists){
			$rules['numero'] .= ',numero,' . $this->id;
        }else{
			$rules['numero'] .= '|required';
        }
        
        $validator = Validator::make($data, $rules);        
        if ($validator->passes()) {
            return true;
        }        
        $this->errors = $validator->errors();        
        return false;
    }

    public static function getData()
    {
        $query = Payment::query();      
        $query->join('contratos', 'contrato', '=', 'contratos.id');
        $query->join('clientes', 'contratos.cliente', '=', 'clientes.id');
        $query->select('recibos.*','clientes.nombre as cliente_nombre','contratos.numero as contrato_numero');        
        if (Input::has("numero")) {
            $query->where('recibos.numero', Input::get("numero"));
        }
        if (Input::has("contrato")) {
            $query->where('contratos.numero', Input::get("contrato"));
        }
        if (Input::has("cliente_cedula")) {         
            $query->where('clientes.cedula', Input::get("cliente_cedula")); 
        }  
        if (Input::has("cliente_nombre")) {          
            $query->where('clientes.nombre', 'like', '%'.Input::get("cliente_nombre").'%');
        }       
        $query->orderby('recibos.fecha', 'DESC');
        return $query->paginate();
    }
}