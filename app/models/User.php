<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $perPage = 6;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	protected $fillable = array('email', 'name', 'password', 'username', 'perfil', 'activo');

	public $errors;

	public $states = array('0' => 'Inactivo', '1' => 'Activo');

	public $profiles = array('A' => 'Administrador', 'D' => 'Digitador', 'C' => 'Consultor');

	public function isValid($data)
    {
        $rules = array(            
            'email'     => 'required|email|unique:users',
            'name' => 'required|min:4|max:40',
            'password'  => 'min:8|confirmed',
        	'username'  => 'required|min:4|max:40|unique:users'
        );
        
        if ($this->exists){
            $rules['email'] .= ',email,' . $this->id;
            $rules['username'] .= ',username,' . $this->id;
        }else{
            $rules['password'] .= '|required';
            $rules['username'] .= '|required';
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

    public function setNameAttribute($name){
		$this->attributes['name'] = strtoupper($name);
	}

	public function setUsernameAttribute($username){
		$this->attributes['username'] = strtoupper($username);
	}

    public function setPasswordAttribute($pass){
    	if (!empty($pass)){
            $this->attributes['password'] = Hash::make($pass);
        }		
	}

    public static function getNameVersion()
    {
        return (Request::getHost() == 'duitama.gruponaturalpower.in') ? '(Duitama)' : '';
    }
}
