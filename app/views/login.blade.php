@extends('layout')

@section('content')

@if(Session::has('mensaje_error'))
    <div class="alert alert-danger">{{ Session::get('mensaje_error') }}</div>
@endif

{{ Form::open(array('url' => '/login', 'class'=>'form-signin')) }}
	<h2 class="form-signin-heading">Iniciar sesión</h2>   
    {{ Form::text('username', Input::old('username'), array(
    	'class' => 'form-control',
    	'placeholder' => "Usuario",
    	'required' => "required")    	
    	); 
    }}
    {{ Form::password('password',array(
    	'class' => 'form-control',
    	'placeholder' => "Contraseña",
    	'required' => "required")
    	); 
    }}
    <label class="checkbox">
		{{ Form::checkbox('rememberme', true) }} Remember me
	</label>    
    {{ Form::submit('Ingresar' , array('class' => 'btn btn-lg btn-primary btn-block')) }}
{{ Form::close() }}
@stop