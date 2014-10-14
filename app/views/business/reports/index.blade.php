@extends ('admin/layout')

@section ('title') Reportes @stop

@section ('content')
	
	<h1 class="page-header">Reportes</h1>
	<p>
		{{ Form::open(array('url' => array('business/reports/carteraedades'), 'method' => 'POST'), array('role' => 'form')) }}			
			{{ Form::submit('Cartera vencida por edades', array('class' => 'btn btn-info')) }}
		{{ Form::close() }}
	</p>      
@stop