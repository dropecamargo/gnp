<?php

class Planilla extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'planilla';

    protected $fillable = array('fecha', 'cobrador', 'zona');

	public $errors;

    protected $perPage = 1;

    public static $key_cart_contracts = 'key_cart_planilla_contracts';

    public static $template_cart_contracts = 'business/planillas/contracts';

    public function isValid($data)
    {
        $rules = array(            
            'fecha' => 'required|date_format:Y-m-d',
            'cobrador' => 'required|numeric|min:1',
            'zona' => 'required|min:2|max:256'
        );
                
        $validator = Validator::make($data, $rules);        
        if ($validator->passes()) {
            return true;
        }        
        $this->errors = $validator->errors();        
        return false;
    }

    public static function getData()
    {
        $query = Planilla::query();      
        $query->join('empleados', 'cobrador', '=', 'empleados.id');
        $query->select('planilla.*','empleados.nombre as cobrador_nombre','empleados.cedula as cobrador_cedula');        
        if (Input::has("cobrador")) {
            if(Input::get("cobrador") != 0){
                $query->where('planilla.cobrador', Input::get("cobrador"));
            }
        }      
        $query->orderby('planilla.fecha', 'DESC');
        return $query->paginate();
    }
}