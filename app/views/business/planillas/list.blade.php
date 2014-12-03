@extends ('admin/layout')

@section ('title') Planillas de cobro @stop

@section ('content')

	<h1 class="page-header">Planillas de cobro</h1>

	{{ Form::open(array('route' => 'business.planilla.index', 'method' => 'POST', 'id' => 'form-search-planillas'), array('role' => 'form')) }}				
	<h4 class="page-header">Formulario de busqueda</h4>   	
	<div class="row">
        <div class="form-group col-md-12" align="center">
            {{ Form::label('cobrador', 'Cobrador') }}
            {{ Form::select('cobrador', array('0' => 'Seleccione cobrador') + $collectors ,null, array('class' => 'form-control', 'style' => 'width:50%;')) }}
        </div>	
 	</div>
	<div class="row" align="center">
		<button type="submit" class="btn btn-primary">Buscar</button>
		{{Form::button('Limpiar', array('class'=>'btn btn-primary', 'id' => 'button-clear-search-planillas' ));}} 
		{{--*/ $allowed = array('A') /*--}}
    	@if (in_array(Auth::user()->perfil, $allowed))
			<a href="{{ route('business.planilla.create') }}" class="btn btn-primary">Nueva Planilla</a>			
		@endif
	</div>
	<br/>
 	{{ Form::close() }}	
	<div id="planillas">
		@include('business.planillas.planillas')
	</div>
	<script type="text/javascript">		
		var root_url = "<?php echo Request::root(); ?>/";
		var planillas = { 			
			search : function(){
				var url = root_url + 'business/planilla';	
				$.ajax({	
					url: url,		
					type : 'get',
					data: $('#form-search-planillas').serialize(),	
					datatype: "html",
					beforeSend: function() {
						$('#loading-app').modal('show')
					}
				})
				.done(function(data) {		
					$('#loading-app').modal('hide')
					$('#planillas').empty().html(data.html)
				})
				.fail(function(jqXHR, ajaxOptions, thrownError)
				{
					$('#loading-app').modal('hide');
					$('#error-app').modal('show');
					$("#error-app-label").empty().html("No hay respuesta del servidor - Consulte al administrador.");				
				});
			},
			clearSearch : function(){
				$("#cobrador").val('0')
			}
		}

		$("#form-search-planillas").submit(function( event ) {  
			event.preventDefault()
			planillas.search()	
		})

		$("#button-clear-search-planillas").click(function( event ) {  
			planillas.clearSearch()
			planillas.search()	
		})
	</script>
@stop