@extends ('admin/layout')

@section ('title') Reportes Estado de Cuenta @stop

@section ('content')
	
	{{--*/ $allowed = array('A','C') /*--}}
    @if (in_array(Auth::user()->perfil, $allowed))
		<h1 class="page-header">Estado de cuenta</h1>
		<div class="row">
		    <div class="form-group col-md-4">
		        <a href="{{ route('business.reports.index') }}" class="btn btn-info">Reportes</a>
		    </div>
		    <div class="form-group col-md-4">
		        {{ Form::open(array('url' => array('business/reports/estadocuentapdf'), 'method' => 'POST'), array('role' => 'form')) }}										
					{{ Form::hidden('cliente', $cliente, array('id' => 'cliente')) }}
					<button type="submit" class="btn btn-danger">
						<span class="glyphicon glyphicon-file"></span>
	        			Exportar PDF	
					</button>			
				{{ Form::close() }}
		    </div>
	  	</div>  
		<div class="row" align="center">
			{{ $html }}	
		</div>	
	@else
		@include('denied')
	@endif
@stop