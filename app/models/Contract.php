<?php

class Contract extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contratos';

	protected $fillable = array('numero', 'fecha', 'cliente', 'vendedor', 'valor', 'cuotas', 'primera');

	public $errors;

	public function isValid($data)
    {
        $rules = array(            
            'numero' => 'required|min:1|max:10|unique:contratos|regex:[^[0-9]*$]',            
            'fecha' => 'required|date_format:Y-m-d',
            'cliente_cedula' => 'required|min:5|max:15',
            'cliente' => 'required|numeric',
            'vendedor' => 'required|numeric|min:1',
            'cuotas' => 'required|min:1|max:10|regex:[^[0-9]*$]|numeric',
            'primera' => 'required|date_format:Y-m-d',
            'valor' => 'required|min:1|regex:[^[0-9]*$]'
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

    public function suma_fechas($fecha){
        $ndias = 30;
        if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha)) {
            list($ao,$mes,$dia) = explode("/", $fecha);
        }else if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha)) {
            list($ao,$mes,$dia) = explode("-", $fecha);
        }else{
            return NULL;
        }
        $nueva = mktime(0,0,0, $mes,$dia,$ao) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("Y-m-d",$nueva);
        return ($nuevafecha);
    }
}