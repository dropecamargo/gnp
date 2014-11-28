@extends ('admin/layout')

@section ('title') Reportes @stop

@section ('content')
	
	{{--*/ $allowed = array('A','C') /*--}}
    @if (in_array(Auth::user()->perfil, $allowed))
		<h1 class="page-header">Reportes</h1>
		<div class="panel-group" id="accordion-reportes" role="tablist" aria-multiselectable="true">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion-reportes" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							Cartera vencida por edades
						</a>
					</h4>
				</div>
				<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						{{ Form::open(array('url' => array('business/reports/carteraedades'), 'method' => 'POST'), array('role' => 'form')) }}									
							<div class="row" align="center">
								<div class="form-group col-md-3"></div>
								<div class="form-group col-md-6">
								{{ Form::label('edades', 'Edad Cartera') }}						
								{{ Form::select('edades', array(
									'T' => 'Todas', '30' => '1 A 30', 
									'60' => '31 A 60', '90' => '61 A 90',
									'180' => '91 A 180', '360' => '181 A 360',
									'370' => 'MAS DE 360'),'T',array('class' => 'form-control', 'style' => 'width:30;')) 
								}}
								</div>
								<div class="form-group col-md-3"></div>
							</div>
							<p align="center">
								{{ Form::submit('Generar', array('class' => 'btn btn-info')) }}
							</p>
						{{ Form::close() }}	
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
					<a class="collapsed" data-toggle="collapse" data-parent="#accordion-reportes" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						Estado de cuenta
					</a>
					</h4>
				</div>
				<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
						{{ Form::open(array('url' => array('business/reports/estadocuenta'), 'method' => 'POST'), array('role' => 'form')) }}									
							<div class="row" align="center">
								<div class="form-group col-md-1"></div>
								<div class="form-group col-md-3">
									{{ Form::label('cliente_cedula', 'Cliente') }}
						           	{{ Form::text('cliente_cedula', null, array('placeholder' => 'Ingrese cliente', 'class' => 'form-control')) }}        
						        	{{ Form::hidden('cliente', null, array('id' => 'cliente')) }}
								</div>
								<div class="form-group col-md-7">   
									{{ Form::label('cliente_nombre', 'Nombre') }}     	
						            {{ Form::text('cliente_nombre', null, array('class' => 'form-control', 'disabled' => 'disabled')) }}        
						        </div>
								<div class="form-group col-md-1"></div>
							</div>
							<p align="center">
								{{ Form::submit('Generar', array('class' => 'btn btn-info')) }}
							</p>
						{{ Form::close() }}
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingThree">
					<h4 class="panel-title">
					<a class="collapsed" data-toggle="collapse" data-parent="#accordion-reportes" href="#collapseThree" aria-expanded="false" aria-controls="collapseTwo">
						Recibos de caja
					</a>
					</h4>
				</div>
				<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
					<div class="panel-body">
						{{ Form::open(array('url' => array('business/reports/reciboscaja'), 'method' => 'POST'), array('role' => 'form')) }}									
							<div class="row" align="center">
								<div class="form-group col-md-3"></div>
								<div class="form-group col-md-6">
								{{ Form::label('tipo', 'Tipo') }}
								{{ Form::select('tipo', array(
									'0' => 'Todos', 'PA' => 'Pago', 'DE' => 'Descuento', 'DV' => 'Devolución'),
									'T',array('class' => 'form-control', 'style' => 'width:30;')) 
								}}
								</div>
								<div class="form-group col-md-3"></div>
							</div>
							<p align="center">
								{{ Form::submit('Generar', array('class' => 'btn btn-info')) }}
							</p>
						{{ Form::close() }}
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingFour">
					<h4 class="panel-title">
					<a class="collapsed" data-toggle="collapse" data-parent="#accordion-reportes" href="#collapseFour" aria-expanded="false" aria-controls="collapseTwo">
						Ventas de un periodo
					</a>
					</h4>
				</div>
				<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
					<div class="panel-body">
						{{ Form::open(array('url' => array('business/reports/ventasperiodo'), 'method' => 'POST', 'id' => 'form-reporte-ventas'), array('role' => 'form')) }}									
							<div class="row" align="center">
								<div class="form-group col-md-1"></div>
								<div class="form-group col-md-4">
									{{ Form::label('fecha_inicial', 'Fecha Inicial') }}
						            <div class="input-append date">	
						            	{{ Form::text('fecha_inicial', date('Y-m-d'), array('placeholder' => 'yyyy-mm-dd', 'class' => 'form-control')) }}        
						        	</div>
								</div>
								<div class="form-group col-md-4">
									{{ Form::label('fecha_final', 'Fecha Final') }}
						            <div class="input-append date">	
						            	{{ Form::text('fecha_final', date('Y-m-d'), array('placeholder' => 'yyyy-mm-dd', 'class' => 'form-control')) }}        
						        	</div>
								</div>
								<div class="form-group col-md-2">        	
						            {{ Form::label('detallado', '¿Detallado?') }}
						    		{{ Form::checkbox('detallado', 'value') }}
						        </div>
								<div class="form-group col-md-1"></div>
							</div>
							<p align="center">
								{{ Form::button('Generar', array('class' => 'btn btn-info', 'id' => 'btn-submit-reporte-ventas' )) }}
							</p>
						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			$(function() {	
				var root_url = "<?php echo Request::root(); ?>/";

				$("#fecha_inicial").datepicker({
	                changeMonth: true,
	                changeYear: true,
	                dateFormat: "yy-mm-dd"              
            	})

            	$("#fecha_final").datepicker({
	                changeMonth: true,
	                changeYear: true,
	                dateFormat: "yy-mm-dd"              
            	})

	
            	$("#btn-submit-reporte-ventas").click(function() {
					if(!$("#fecha_inicial").val()){
		            	alertify.error("Por favor seleccione fecha inicial.");
		            	return
		            }
		            if(!$("#fecha_final").val()){
		            	alertify.error("Por favor seleccione fecha final.");
		            	return
		            }
					$("#form-reporte-ventas").submit();
				});

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

			});
		</script>
	@else
		@include('denied')
	@endif
@stop