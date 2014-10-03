@extends ('admin/layout')

@section ('title') Usuario @stop

@section ('content')
	
	<h1 class="page-header">Usuario</h1>

	<div class="row">
	    <div class="form-group col-md-4">
	        <a href="{{ route('admin.users.index') }}" class="btn btn-info">Lista de usuarios</a>
	    </div>
  	</div> 

	<div class="row">
		<div class="form-group col-md-4">
			<label>Nombre</label>
			<div>{{ $user->name }}</div> 
		</div>
		<div class="form-group col-md-4">
			<label>Cuenta</label>
			<div>{{ $user->username }}</div> 
		</div>
		<div class="form-group col-md-4">
		    <label>Dirección de E-mail</label>
			<div>{{ $user->email }}</div>
		</div>
    </div>
    <div class="row">
		<div class="form-group col-md-4">
			<label>Perfil</label>
			<div>{{ $user->profiles[$user->perfil] }}</div>
      	</div>
      	<div class="form-group col-md-4">
        	<label>Estado</label>
        	<div>{{ $user->states[$user->activo] }}</div>
        </div>  
    </div>
    <div class="row">
		<div class="form-group col-md-4">
			<label>Creación</label>
			<div>{{ $user->created_at }}</div>
      	</div>
      	<div class="form-group col-md-4">
        	<label>Actualización</label>
        	<div>{{ $user->updated_at }}</div>
        </div>  
    </div>
    <p>			
		{{ Form::model($user, array('route' => array('admin.users.destroy', $user->id), 'method' => 'DELETE'), array('role' => 'form')) }}			
			<a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-success">Editar</a>		
			{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
		{{ Form::close() }}
	</p>	

@stop