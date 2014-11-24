@extends ('admin/layout')

@section ('title') Recibos de pago @stop

@section ('content')
	
	<h1 class="page-header">Recibos de pago</h1>
	{{ Form::open(array('route' => 'business.payments.index', 'method' => 'POST', 'id' => 'form-search-payments'), array('role' => 'form')) }}				
	<h4 class="page-header">Formulario de busqueda</h4>   	
	<div class="row">
        <div class="form-group col-md-2">
            {{ Form::label('numero', 'Número') }}
            {{ Form::text('numero', null, array('placeholder' => 'Recibo', 'class' => 'form-control')) }}        
        </div>
        <div class="form-group col-md-2">
            {{ Form::label('contrato', 'Contrato') }}
            {{ Form::text('contrato', null, array('placeholder' => 'Contrato', 'class' => 'form-control')) }}        
        </div>	
        <div class="form-group col-md-3">
        	{{ Form::label('cliente_cedula', 'Cliente') }}
            {{ Form::text('cliente_cedula', null, array('placeholder' => 'Ingrese cliente', 'class' => 'form-control')) }}        
        </div>
        <div class="form-group col-md-5">        	
            {{ Form::label('cliente_nombre', 'Nombre') }}
            {{ Form::text('cliente_nombre', null, array('placeholder' => 'Ingrese nombre', 'class' => 'form-control')) }}        
        </div>
 	</div> 	
 	<div class="row" align="center">
		<button type="submit" class="btn btn-primary">Buscar</button>
		{{Form::button('Limpiar', array('class'=>'btn btn-primary', 'id' => 'button-clear-search-payments' ));}} 
		{{--*/ $allowed = array('A','D') /*--}}
    	@if (in_array(Auth::user()->perfil, $allowed))
    		<a href="{{ route('business.payments.create') }}" class="btn btn-primary">Nuevo recibo</a>					
		@endif
	</div>
	<br/>
 	{{ Form::close() }}	

	
	{{--*/ $allowed = array('A','D') /*--}}
    @if (in_array(Auth::user()->perfil, $allowed))
	   	<div class="row">		
		  	<div class="form-group col-md-4">
			</div>	
		</div>
	@endif			
	<div id="payments">
		@include('business.payments.payments')
	</div>
	<script type="text/javascript">		
		var root_url = "<?php echo Request::root(); ?>/";
		var payments = { 			
			search : function(){
				var url = root_url + 'business/payments';	
				$.ajax({	
					url: url,		
					type : 'get',
					data: $('#form-search-payments').serialize(),	
					datatype: "html",
					beforeSend: function() {
						$('#loading-app').modal('show')
					}
				})
				.done(function(data) {		
					$('#loading-app').modal('hide')
					$('#payments').empty().html(data.html)
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
				$("#contrato").val('')
				$('#cliente').val('')
    			$('#cliente_cedula').val('')
    			$('#cliente_nombre').val('')
			}
		}

		$("#form-search-payments").submit(function( event ) {  
			event.preventDefault()
			payments.search()	
		})

		$("#button-clear-search-payments").click(function( event ) {  
			payments.clearSearch()
			payments.search()	
		})
	</script>
	
@stop