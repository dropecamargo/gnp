<?php

class Contract extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contratos';

    protected $perPage = 6;

	protected $fillable = array('numero', 'fecha', 'cliente', 'valor', 'cuotas', 'primera');

	public $errors;

	public function isValid($data)
    {
        $rules = array(            
            'numero' => 'required|min:1|max:10|unique:contratos|regex:[^[0-9]*$]',            
            'fecha' => 'required|date_format:Y-m-d',
            'cliente_cedula' => 'required|min:5|max:15',
            'cliente' => 'required',
            'cuotas' => 'required|min:1|max:10|regex:[^[0-9]*$]',
            'primera' => 'required|date_format:Y-m-d',
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
}