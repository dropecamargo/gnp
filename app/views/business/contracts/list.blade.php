@extends ('admin/layout')

@section ('title') Contratos @stop

@section ('content')

	<h1 class="page-header">Contratos</h1>
	{{ Form::open(array('route' => 'business.contracts.index', 'method' => 'POST', 'id' => 'form-search-contracts'), array('role' => 'form')) }}				
	<h4 class="page-header">Formulario de busqueda</h4>   	
	<div class="row">
        <div class="form-group col-md-3">
            {{ Form::label('numero', 'Número') }}
            {{ Form::text('numero', null, array('placeholder' => 'Número contrato', 'class' => 'form-control')) }}        
        </div>	
        <div class="form-group col-md-3">
        	{{ Form::label('cliente_cedula', 'Cliente') }}
            {{ Form::text('cliente_cedula', null, array('placeholder' => 'Ingrese cliente', 'class' => 'form-control')) }}        
        </div>
        <div class="form-group col-md-4">        	
            {{ Form::label('cliente_nombre', 'Nombre') }}
            {{ Form::text('cliente_nombre', null, array('placeholder' => 'Ingrese nombre', 'class' => 'form-control')) }}        
        </div>
        <div class="form-group col-md-2">        	
            {{ Form::label('saldo', 'Saldo > 0') }}
    		{{ Form::checkbox('saldo', 'value') }}
        </div>
 	</div> 	
 	<div class="row" align="center">
		<button type="submit" class="btn btn-primary">Buscar</button>
		{{Form::button('Limpiar', array('class'=>'btn btn-primary', 'id' => 'button-clear-search-contracts' ));}} 
		{{--*/ $allowed = array('A','D') /*--}}
    	@if (in_array(Auth::user()->perfil, $allowed))
			<a href="{{ route('business.contracts.create') }}" class="btn btn-primary">Nuevo Contrato</a>			
		@endif
	</div>
	<br/>
 	{{ Form::close() }}	
	<div id="contracts">
		@include('business.contracts.contracts')
	</div>
	<script type="text/javascript">		
		var root_url = "<?php echo Request::root(); ?>/";
		var contracts = { 			
			search : function(){
				var url = root_url + 'business/contracts';	
				$.ajax({	
					url: url,		
					type : 'get',
					data: $('#form-search-contracts').serialize(),	
					datatype: "html",
					beforeSend: function() {
						$('#loading-app').modal('show')
					}
				})
				.done(function(data) {		
					$('#loading-app').modal('hide')
					$('#contracts').empty().html(data.html)
				})
				.fail(function(jqXHR, ajaxOptions, thrownError)
				{
					$('#loading-app').modal('hide');
					$('#error-app').modal('show');
					$("#error-app-label").empty().html("No hay respuesta del servidor - Consulte al administrador.");				
				});
			},
			clearSearch : function(){
				$("#numero").val('')
				$('#cliente').val('')
    			$('#cliente_cedula').val('')
    			$('#cliente_nombre').val('')
    			$('#saldo').prop('checked' , false);
			}
		}

		$("#form-search-contracts").submit(function( event ) {  
			event.preventDefault()
			contracts.search()	
		})

		$("#button-clear-search-contracts").click(function( event ) {  
			contracts.clearSearch()
			contracts.search()	
		})
	</script>
@stop