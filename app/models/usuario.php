<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class usuario extends Eloquent implements UserInterface, RemindableInterface 
{

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'usuario';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	
	
	protected $fillable = array('usuario_cuenta', 'usuario_nombre', 'usuario_clave', 'usuario_perfil', 'usuario_activo');
	
	protected $perPage = 4;
	
	public $errors;
    
    public function isValid($data)
    {
        $rules = array(
            'usuario_cuenta'     => 'required|min:3|max:20|unique:usuario',
            'usuario_nombre'     => 'required|min:4|max:100',
            'usuario_clave'      => 'min:5|confirmed'
        );
        
		// Si el usuario existe:
        if ($this->exists)
        {
            //Evitamos que la regla “unique” tome en cuenta el email del usuario actual
            $rules['usuario_cuenta'] .= ',usuario_cuenta,' . $this->id;
        }
        else // Si no existe...
        {
            // La clave es obligatoria:
            $rules['usuario_clave'] .= '|required';
        }
		
		
        $validator = Validator::make($data, $rules);
        
        if ($validator->passes())
        {
            return true;
        }
        
        $this->errors = $validator->errors();
        
        return false;
    }
	
	public function setusuario_claveAttribute($value)
    {
        if ( ! empty ($value))
        {
            $this->attributes['usuario_clave'] = Hash::make($value);
        }
    }
	
	
	 public function getusuario_nombreAttribute()
    {
        return strtoupper($this->attributes['usuario_nombre']);
    }

	public function validAndSave($data)
    {
        // Revisamos si la data es válida
        if ($this->isValid($data))
        {
            // Si la data es valida se la asignamos al usuario
            $this->fill($data);
            // Guardamos el usuario
            $this->save();
            
            return true;
        }
        
        return false;
    }
	
}
