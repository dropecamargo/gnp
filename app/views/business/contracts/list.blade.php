@extends ('admin/layout')

@section ('title') Contratos @stop

@section ('content')

	<h1 class="page-header">Contratos</h1>
   	<div class="row">		
	  	<div class="form-group col-md-4">
			<a href="{{ route('business.contracts.create') }}" class="btn btn-primary">Nuevo contrato</a>					
		</div>					
	</div>
	<div id="contracts">
		@include('business.contracts.contracts')
	</div>
	
@stop