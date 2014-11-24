@extends ('admin/layout')

@section ('title') Productos @stop

@section ('content')

	<h1 class="page-header">Productos</h1>
	{{ Form::open(array('route' => 'business.products.index', 'method' => 'POST', 'id' => 'form-search-produts'), array('role' => 'form')) }}				
	<h4 class="page-header">Formulario de busqueda</h4>   	
	<div class="row">	
        <div class="form-group col-md-6">        	
            {{ Form::label('producto_nombre', 'Nombre') }}
            {{ Form::text('producto_nombre', null, array('class' => 'form-control', 'placeholder' => 'Ingrese nombre')) }}        
        </div>
 	</div> 	
 	<div class="row" align="center">
		<button type="submit" class="btn btn-primary">Buscar</button>
		{{Form::button('Limpiar', array('class'=>'btn btn-primary', 'id' => 'button-clear-search-products' ));}} 	
		{{--*/ $allowed = array('A') /*--}}
    	@if (in_array(Auth::user()->perfil, $allowed))
			<a href="{{ route('business.products.create') }}" class="btn btn-primary">Nuevo producto</a>
		@endif
	</div>
	<br/>
 	{{ Form::close() }}
	<div id="products">
		@include('business.products.products')
	</div>

	<script type="text/javascript">		
		var root_url = "<?php echo Request::root(); ?>/";
		var products = { 			
			search : function(){
				var url = root_url + 'business/products';	
				$.ajax({	
					url: url,		
					type : 'get',
					data: $('#form-search-produts').serialize(),	
					datatype: "html",
					beforeSend: function() {
						$('#loading-app').modal('show')
					}
				})
				.done(function(data) {		
					$('#loading-app').modal('hide')
					$('#products').empty().html(data.html)
				})
				.fail(function(jqXHR, ajaxOptions, thrownError)
				{
					$('#loading-app').modal('hide');
					$('#error-app').modal('show');
					$("#error-app-label").empty().html("No hay respuesta del servidor - Consulte al administrador.");				
				});
			},
			clearSearch : function(){
    			$('#producto_nombre').val('')
			}
		}

		$("#form-search-produts").submit(function( event ) {  
			event.preventDefault()
			products.search()	
		})

		$("#button-clear-search-products").click(function( event ) {  
			products.clearSearch()
			products.search()	
		})
	</script>
@stop