@extends ('admin/layout')

@section ('title') Grupo @stop

@section ('content')
	
	<h1 class="page-header">Grupo</h1>

	<div class="row">
	    <div class="form-group col-md-4">
	        <a href="{{ route('business.groups.index') }}" class="btn btn-info">Lista de grupos</a>
	    </div>
  	</div> 

    <div class="row">		
		<div class="form-group col-md-4">
			<label>Nombre</label>
			<div>{{ $group->nombre }}</div> 
		</div>

      	<div class="form-group col-md-4">
        	<label>Estado</label>
        	<div>{{ $group->states[$group->activo] }}</div>
        </div>  
    </div>
    <div class="row">
		<div class="form-group col-md-4">
			<label>Creación</label>
			<div>{{ $group->created_at }}</div>
      	</div>
      	<div class="form-group col-md-4">
        	<label>Actualización</label>
        	<div>{{ $group->updated_at }}</div>
        </div>  
    </div>
   
   {{--*/ $allowed = array('A') /*--}}
    @if (in_array(Auth::user()->perfil, $allowed))
	    <p>			
			{{ Form::model($group, array('route' => array('business.groups.destroy', $group->id), 'method' => 'DELETE'), array('role' => 'form')) }}			
				<a href="{{ route('business.groups.edit', $group->id) }}" class="btn btn-success">Editar</a>		
				{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
			{{ Form::close() }}
		</p>
	@endif	
   		
@stop