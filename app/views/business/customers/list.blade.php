@extends ('admin/layout')

@section ('title') Clientes @stop

@section ('content')

	<h1 class="page-header">Clientes</h1>
	{{ Form::open(array('route' => 'business.customers.index', 'method' => 'POST', 'id' => 'form-search-customers'), array('role' => 'form')) }}				
	<h4 class="page-header">Formulario de busqueda</h4>   	
	<div class="row">	
        <div class="form-group col-md-3">
        	{{ Form::label('cliente_cedula', 'Cliente') }}
            {{ Form::text('cliente_cedula', null, array('placeholder' => 'Ingrese cliente', 'class' => 'form-control')) }}        
        </div>
        <div class="form-group col-md-6">        	
            {{ Form::label('cliente_nombre', 'Nombre') }}
            {{ Form::text('cliente_nombre', null, array('class' => 'form-control', 'placeholder' => 'Ingrese nombre')) }}        
        </div>
 	</div> 	
 	<div class="row" align="center">
		<button type="submit" class="btn btn-primary">Buscar</button>
		{{Form::button('Limpiar', array('class'=>'btn btn-primary', 'id' => 'button-clear-search-customers' ));}} 
	</div>
	<br/>
 	{{ Form::close() }}
 	<div id="customers">
		@include('business.customers.customers')
	</div>
	<script type="text/javascript">		
		var root_url = "<?php echo Request::root(); ?>/";
		var customers = { 			
			search : function(){
				var url = root_url + 'business/customers';	
				$.ajax({	
					url: url,		
					type : 'get',
					data: $('#form-search-customers').serialize(),	
					datatype: "html",
					beforeSend: function() {
						$('#loading-app').modal('show')
					}
				})
				.done(function(data) {		
					$('#loading-app').modal('hide')
					$('#customers').empty().html(data.html)
				})
				.fail(function(jqXHR, ajaxOptions, thrownError)
				{
					$('#loading-app').modal('hide');
					$('#error-app').modal('show');
					$("#error-app-label").empty().html("No hay respuesta del servidor - Consulte al administrador.");				
				});
			},
			clearSearch : function(){
				$("#cliente_cedula").val('')
				$('#cliente_nombre').val('')
			}
		}

		$("#form-search-customers").submit(function( event ) {  
			event.preventDefault()
			customers.search()	
		})

		$("#button-clear-search-customers").click(function( event ) {  
			customers.clearSearch()
			customers.search()	
		})
	</script>
@stop