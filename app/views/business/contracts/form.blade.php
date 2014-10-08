@extends ('admin/layout')

<?php
	// Data contract
    if ($contract->exists):
        $form_data = array('route' => array('business.contracts.update', $contract->id), 'method' => 'PATCH');
        $form_data_customer = array('route' => array('business.customers.update', $customer->id), 'method' => 'PATCH', 'id' => 'form-add-customer');        
        $action    = 'Editar';
    else:
        $form_data = array('route' => 'business.contracts.store', 'method' => 'POST');
    	$form_data_customer = array('route' => 'business.customers.store', 'method' => 'POST', 'id' => 'form-add-customer');    	
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

	@include ('errors', array('errors' => $errors))

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
            {{ Form::text('cliente_cedula', null, array('placeholder' => 'Ingrese cliente', 'class' => 'form-control')) }}        
        	{{ Form::hidden('cliente', null, array('id' => 'cliente')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('cliente_nombre', 'Nombre') }}
            {{ Form::text('cliente_nombre', null, array('class' => 'form-control', 'disabled' => 'disabled')) }}        
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
            {{ Form::label('primera', 'Primera cuota') }}
            {{ Form::text('primera', null, array('placeholder' => 'yyyy-mm-dd', 'class' => 'form-control')) }}        
        </div>        
    </div>
	{{ Form::button($action . ' contrato', array('type' => 'submit', 'class' => 'btn btn-success')) }}        
	
	{{ Form::close() }}
	 
	<!-- Large modal -->
	<div class="modal fade" id="modal-client" data-backdrop="static" data-keyboard="false" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div id="validation-errors-client" style="display: none"></div>
				{{ Form::model($customer, $form_data_customer, array('role' => 'form')) }}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">Crear cliente</h4>
					</div>
					<div class="modal-body">
						@include ('business/customers/template', array())	
					</div>
					<div class="modal-footer">
						<button type="button" id="btn-close-modal-client" class="btn btn-default">Cerrar</button>
						{{ Form::button('Crear cliente', array('type' => 'submit', 'class' => 'btn btn-success')) }}        					
					</div>
				{{ Form::close() }}
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

			$("#cliente_cedula").change(function() {
				var inputVal = $(this).val();
			    var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
			    if(!numericReg.test(inputVal)) {
			    	$(this).val('')
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
		                	$('#loading-app').modal('hide');
		                	if(data.success == false) {
								$('#cedula').val(inputVal)
								$('#modal-client').modal('show')	
		                	}else{		                	
		                		$('#cliente').val(data.customer.id);
	                    		$('#cliente_cedula').val(data.customer.cedula);
	                    		$('#cliente_nombre').val(data.customer.nombre);	
		                	}		                	
		                },
		                error: function(xhr, textStatus, thrownError) {
							$('#loading-app').modal('hide');
							$('#error-app').modal('show');
							$("#error-app-label").empty().html("No hay respuesta del servidor - Consulte al administrador.");				
		                }
		            });											
				}
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
			
		    $('#form-add-customer').on('submit', function(){ 							 
		       	var url = root_url + 'business/customers';    		
				$.ajax({
	                type: 'post',
	                cache: false,
	                dataType: 'json',
	                data: $('#form-add-customer').serialize(),
	                url : url,
	                beforeSend: function() { 
						$("#validation-errors-client").hide().empty();	                                   
	                },
	                success: function(data) {
	                    if(data.success == false) {
	                        $("#validation-errors-client").append(data.errors);
	                        $("#validation-errors-client").show();
	                    } else {
	                    	$('#modal-client').modal('hide');
	                    	$('#cliente').val(data.customer.id);
	                    	$('#cliente_cedula').val(data.customer.cedula);
	                    	$('#cliente_nombre').val(data.customer.nombre);
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
		});
	</script>

@stop