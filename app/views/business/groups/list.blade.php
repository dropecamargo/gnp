@extends ('admin/layout')

@section ('title') Grupos @stop

@section ('content')

	<h1 class="page-header">Grupos</h1>
   	{{--*/ $allowed = array('A') /*--}}
    @if (in_array(Auth::user()->perfil, $allowed))
	   	<div class="row">		
		  	<div class="form-group col-md-4">
				<a href="{{ route('business.groups.create') }}" class="btn btn-primary">Nuevo grupo</a>					
			</div>					
		</div>
	@endif
	<div id="groups">
		@include('business.groups.groups')
	</div>

@stop