<?php

class Payment extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'recibos';

	public $types = array('PA' => 'Pago', 'DE' => 'Descuento', 'DV' => 'Devolución');

	protected $fillable = array('numero', 'fecha', 'contrato', 'cobrador', 'tipo', 'valor');

	public function isValid($data)
    {
        $rules = array(            
            'numero' => 'required|min:1|max:10|unique:recibos|regex:[^[0-9]*$]',            
            'fecha' => 'required|date_format:Y-m-d',
            'contrato_numero' => 'required|min:1|max:10',
            'contrato' => 'required|numeric',
            'cobrador' => 'required|numeric|min:1',
            'valor' => 'required|min:1|regex:[^[0-9]*$]',
            'tipo' => 'required'
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
}