@extends ('admin/layout')

@section ('title') Recibos de pago @stop

@section ('content')

	<h1 class="page-header">Recibos de pago</h1>
   	<div class="row">		
	  	<div class="form-group col-md-4">
			<a href="{{ route('business.payments.create') }}" class="btn btn-primary">Nuevo recibo</a>					
		</div>					
	</div>
	<div id="payments">
		@include('business.payments.payments')
	</div>
	
@stop