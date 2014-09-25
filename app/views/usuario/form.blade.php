@extends ('usuario/layout')

<?php
    if ($usuario->exists):
        $form_data = array('route' => array('usuario.update', $usuario->id), 'method' => 'PATCH');
        $action    = 'Editar';
    else:
        $form_data = array('route' => 'usuario.store', 'method' => 'POST');
        $action    = 'Crear';        
    endif;
?>




@section ('title') {{ $action }} Usuarios @stop

@section ('content')

  <h1>{{ $action }} Usuarios</h1>
  <p>
    <a href="{{ route('usuario.index') }}" class="btn btn-info">Lista de usuarios</a>
  </p>
  @if ($action == 'Editar')  
{{ Form::model($usuario, array('route' => array('usuario.destroy', $usuario->id), 'method' => 'DELETE', 'role' => 'form')) }}
  <div class="row">
    <div class="form-group col-md-4">
        {{ Form::submit('Eliminar usuario', array('class' => 'btn btn-danger')) }}
    </div>
  </div>
{{ Form::close() }}
@endif
{{ Form::model($usuario, $form_data, array('role' => 'form')) }}

@include ('usuario/errors', array('errors' => $errors))


  <div class="row">
    <div class="form-group col-md-4">
      {{ Form::label('usuario_cuenta', 'Cuenta') }}
      {{ Form::text('usuario_cuenta', null, array('placeholder' => 'Introduce tu Cuenta', 'class' => 'form-control')) }}
    </div>
    <div class="form-group col-md-4">
      {{ Form::label('usuario_nombre', 'Nombres completos') }}
      {{ Form::text('usuario_nombre', null, array('placeholder' => 'Introduce tu nombre y apellido', 'class' => 'form-control')) }}        
    </div>
  </div>
  
  <div class="row">
    <div class="form-group col-md-4">
      {{ Form::label('usuario_clave', 'Clave') }}
      {{ Form::password('usuario_clave', array('class' => 'form-control')) }}
    </div>
    <div class="form-group col-md-4">
      {{ Form::label('usuario_clave_confirmation', 'Confirmar clave') }}
      {{ Form::password('usuario_clave_confirmation', array('class' => 'form-control')) }}
    </div>
  </div>
  <div class="row">
    <div class="form-group col-md-4">
      {{ Form::label('usuario_perfil', 'Perfil') }}
      {{ Form::select('usuario_perfil', array('A' => 'Administrador', 'D' => 'Digitador', 'C' => 'Consultor'),'C') }}
    </div>
    <div class="form-group col-md-4">
      {{ Form::label('usuario_activo', 'Usuario activo') }}
      {{ Form::select('usuario_activo', array('1' => 'Activo', '0' => 'Inactivo'), '1') }}        
    </div>
  </div>
  {{ Form::button('Crear usuario', array('type' => 'submit', 'class' => 'btn btn-primary')) }}    
  
{{ Form::close() }}

@stop