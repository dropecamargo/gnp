@extends ('admin/layout')

@section ('title') Usuarios @stop

@section ('content')

	<h1 class="page-header">Usuarios</h1>
   	<div class="row">		
	  	<div class="form-group col-md-4">
			<a href="{{ route('admin.users.create') }}" class="btn btn-primary">Nuevo usuario</a>					
		</div>					
	</div>
	<div id="users">
		@include('admin.users.users')
	</div>
	
@stop