@extends ('admin/layout')

<?php
	// Data contract
    if ($contract->exists):
        $form_data = array('route' => array('business.contracts.update', $contract->id), 'method' => 'PATCH', 'id' => 'form-add-contract');
        $action    = 'Editar';        
    else:
        $form_data = array('route' => 'business.contracts.store', 'method' => 'POST', 'id' => 'form-add-contract');
        $action    = 'Crear';        
    endif;
?>

@section ('title') {{ $action }} contrato @stop

@section ('content')
	
	<h1 class="page-header">{{ $action }} contrato</h1>

	<div class="row">
	    <div class="form-group col-md-4">
	        <a href="{{ route('business.contracts.index') }}" class="btn btn-info">Lista de contratos</a>
	    </div>
  	</div>  

  	<div id="validation-errors-contract" style="display: none"></div>

  	<div align="center">
    	{{ Form::button($action . ' contrato', array('type' => 'button','class' => 'btn btn-success', 'id' => 'btn-submit-contract' )) }}        
	</div>
	{{ Form::model($contract, $form_data, array('role' => 'form')) }}
	<div class="row">
        <div class="form-group col-md-3">
            {{ Form::label('numero', 'Número') }}
            {{ Form::text('numero', null, array('placeholder' => 'Número contrato', 'class' => 'form-control')) }}        
        </div>
        <div class="form-group col-md-3">
            {{ Form::label('fecha', 'Fecha') }}
            <div class="input-append date">	
            	{{ Form::text('fecha', null, array('placeholder' => 'yyyy-mm-dd', 'class' => 'form-control')) }}        
        	</div>
        </div>
    </div>	
	<div class="row">
        <div class="form-group col-md-3">
        	{{ Form::label('cliente_cedula', 'Cliente') }}
            <span class="glyphicon glyphicon-user" id="customer-glyphicon" style="cursor: pointer;"></span>            
            {{ Form::text('cliente_cedula', null, array('placeholder' => 'Ingrese cliente', 'class' => 'form-control')) }}        
        	{{ Form::hidden('cliente', null, array('id' => 'cliente')) }}
        </div>
        <div class="form-group col-md-6">        	
            {{ Form::label('cliente_nombre', 'Nombre') }}
            {{ Form::text('cliente_nombre', null, array('class' => 'form-control', 'disabled' => 'disabled')) }}        
        </div>
        <div class="form-group col-md-3">
            {{ Form::label('vendedor', 'Vendedor') }}
            {{ Form::select('vendedor', array('0' => 'Seleccione') + $vendors ,null, array('class' => 'form-control')) }}
        </div>        
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            {{ Form::label('valor', 'Valor') }}
            {{ Form::text('valor', null, array('placeholder' => 'Valor', 'class' => 'form-control')) }}        
        </div> 
        <div class="form-group col-md-3">
            {{ Form::label('cuotas', 'Cuotas') }}
            {{ Form::text('cuotas', null, array('placeholder' => 'Número de cuotas', 'class' => 'form-control')) }}        
        </div>
        <div class="form-group col-md-3">
            {{ Form::label('periodicidad', 'Periodicidad de pago') }}
            {{ Form::text('periodicidad', null, array('placeholder' => 'Periodicidad (días)', 'class' => 'form-control')) }}        
        </div> 
        <div class="form-group col-md-3">
            {{ Form::label('primera', 'Primera cuota') }}
            {{ Form::text('primera', null, array('placeholder' => 'yyyy-mm-dd', 'class' => 'form-control')) }}        
        </div>        
    </div>
    {{ Form::close() }}
    
    {{ Form::open(array('route' => 'util.cart.store', 'method' => 'POST', 'id' => 'form-cart-products-contract')) }}
	<div class="row">
		{{ Form::hidden('_key', Contract::$key_cart_products) }}
		{{ Form::hidden('_template', Contract::$template_cart_products) }}
		<div class="form-group col-md-2"></div>
        <div class="form-group col-md-5">
            {{ Form::label('producto', 'Producto') }}
        	{{ Form::select('producto', array('0' => 'Seleccione') + $products ,null, array('class' => 'form-control')) }}
        	{{ Form::hidden('producto_nombre', null,array('id' => 'producto_nombre')) }}
        </div>
        <div class="form-group col-md-2">
            {{ Form::label('cantidad', 'Cantidad') }}
        	{{ Form::text('cantidad', null, array('placeholder' => 'Cantidad', 'class' => 'form-control')) }}        
        </div>
        <div class="form-group col-md-1">
        	<label><span>&nbsp;</span></label>
        	<button type="submit" id="btn-contract-add-product" class="btn btn-default btn-md">
				<span class="glyphicon glyphicon-plus-sign"></span>
			</button>
        </div>
        <div class="form-group col-md-2"></div>
    </div>
    {{ Form::close() }}
    <div id="contract-list-products" style="display:none;"></div>
	
	<div class="modal fade" id="modal-client" data-backdrop="static" data-keyboard="false" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div id="validation-errors-client" style="display: none"></div>				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Cliente</h4>
				</div>
				<div class="modal-body">
					<div id="content-modal-customers"></div>							
				</div>
				<div class="modal-footer">
					<button type="button" id="btn-close-modal-client" class="btn btn-default">Continuar</button>
				</div>				
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		$(function() {
			var root_url = "<?php echo Request::root(); ?>/";

			$('#modal-client').modal({
			  	keyboard: false,			  	
			  	show: false
			})
			
			var event_client = function() {
				var inputVal = $("#cliente_cedula").val();
			    var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
			    
			    $('#cliente').val('')
        		$('#cliente_nombre').val('')

			    if(!numericReg.test(inputVal)) {
			    	$("#cliente_cedula").val('')
			    }else{
			    	var url = root_url + 'business/customers/find';
			    	$.ajax({
		                type: 'post',
		                cache: false,
		                dataType: 'json',
		                data: { cedula : inputVal },
		                url : url,
		                beforeSend: function() {
							$('#loading-app').modal('show');
						},
		                success: function(data) {
		                	$('#loading-app').modal('hide')
		                	$('#content-modal-customers').empty().html(data.customer_form)		                	
		                	if(data.success == false) {
								$('#cedula').val(inputVal)									
		                	}else{		                	
		                		$('#cliente').val(data.customer.id)
	                    		$('#cliente_cedula').val(data.customer.cedula)
	                    		$('#cliente_nombre').val(data.customer.nombre)	
		                	}
		                	$('#modal-client').modal('show')		                	
		                },
		                error: function(xhr, textStatus, thrownError) {
							$('#loading-app').modal('hide');
							$('#error-app').modal('show');
							$("#error-app-label").empty().html("No hay respuesta del servidor - Consulte al administrador.");				
		                }
		            });											
				}				
			};


			$("#cliente_cedula").change(function() {
				event_client();	
			});

			$('#customer-glyphicon').click(function() {
	            event_client();
	        });

        	$("#fecha").datepicker({
				changeMonth: true,
	          	changeYear: true,
	          	dateFormat: "yy-mm-dd"	          	
	        })

	        $("#primera").datepicker({
				changeMonth: true,
	          	changeYear: true,
	          	dateFormat: "yy-mm-dd"	          	
	        })

			$('#btn-close-modal-client').on('click', function(){
				$('#modal-client').modal('hide')
			});	

			$('#form-add-contract').on('submit', function(event){                             
                var url = $(this).attr('action');
                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    data: $('#form-add-contract').serialize(),
                    url : url,
                    beforeSend: function() { 
                        $("#validation-errors-contract").hide().empty();                                     
                    },
                    success: function(data) {
                        if(data.success == false) {
                            $("#validation-errors-contract").append(data.errors);
                            $("#validation-errors-contract").show();
                        }else{
                        	window.location="{{URL::to('business/contracts/"+data.contract.id+"')}}";
                        }
                    },
                    error: function(xhr, textStatus, thrownError) {
                        $('#modal-client').modal('hide');
                        $('#error-app').modal('show');                      
                        $("#error-app-label").empty().html("No hay respuesta del servidor - Consulte al administrador.");               
                    }
                });
                return false;
            });	
			
			$("#producto").change(function() {
				$("#producto_nombre").val($("#producto option:selected").text())
			});

			$("#btn-submit-contract").click(function() {
				$("#form-add-contract").submit();
			});	

			$('#form-cart-products-contract').on('submit', function(event){                             
	            var url = $(this).attr('action')
	            event.preventDefault();
	            if($("#producto").val() == '0'){
	            	alertify.error("Por favor seleccione producto.");
	            	return
	            }
	            if(!$.isNumeric($("#cantidad").val())){
	            	alertify.error("Por favor ingrese cantidad.");
	            	return
	            }
				utilList.store(url,$('#form-cart-products-contract').serialize(),'contract-list-products')
			});
		});
	</script>

@stop