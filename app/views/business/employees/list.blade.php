@extends ('admin/layout')

@section ('title') Empleados @stop

@section ('content')

	<h1 class="page-header">Empleados</h1>
   	{{--*/ $allowed = array('A') /*--}}
    @if (in_array(Auth::user()->perfil, $allowed))
	   	<div class="row">		
		  	<div class="form-group col-md-4">
				<a href="{{ route('business.employees.create') }}" class="btn btn-primary">Nuevo empleado</a>					
			</div>					
		</div>
	@endif
	<div id="employees">
		@include('business.employees.employees')
	</div>

@stop