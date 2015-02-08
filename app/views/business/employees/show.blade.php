@extends ('admin/layout')

@section ('title') Empleado @stop

@section ('content')
	
	<h1 class="page-header">Empleado</h1>

	<div class="row">
	    <div class="form-group col-md-4">
	        <a href="{{ route('business.employees.index') }}" class="btn btn-info">Lista de empleados</a>
	    </div>
  	</div> 

	<div class="row">
		<div class="form-group col-md-4">
			<label>Cédula</label>
			<div>{{ $employee->cedula }}</div> 
		</div>
		<div class="form-group col-md-4">
			<label>Nombre</label>
			<div>{{ $employee->nombre }}</div> 
		</div>
    </div>
    <div class="row">		
      	<div class="form-group col-md-4">
        	<label>Estado</label>
        	<div>{{ $employee->states[$employee->activo] }}</div>
        </div>  
        <div class="form-group col-md-4">
			<label>Vendedor</label>
			<div>
				@if($employee->vendedor == true)
					<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
				@else
					<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
				@endif
			</div>
      	</div>
      	<div class="form-group col-md-4">
			<label>Cobrador</label>
			<div>
				@if($employee->cobrador == true)
					<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
				@else
					<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
				@endif
			</div>
      	</div>
    </div>
    <div class="row">
		<div class="form-group col-md-4">
			<label>Creación</label>
			<div>{{ $employee->created_at }}</div>
      	</div>
      	<div class="form-group col-md-4">
        	<label>Actualización</label>
        	<div>{{ $employee->updated_at }}</div>
        </div>  
    </div>
   
   {{--*/ $allowed = array('A') /*--}}
    @if (in_array(Auth::user()->perfil, $allowed))
	    <p>			
			{{ Form::model($employee, array('route' => array('business.employees.destroy', $employee->id), 'method' => 'DELETE'), array('role' => 'form')) }}			
				<a href="{{ route('business.employees.edit', $employee->id) }}" class="btn btn-success">Editar</a>		
				{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
			{{ Form::close() }}
		</p>
	@endif	
   		
@stop