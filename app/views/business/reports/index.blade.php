@extends ('admin/layout')

@section ('title') Reportes @stop

@section ('content')
	
	{{--*/ $allowed = array('A','C') /*--}}
    @if (in_array(Auth::user()->perfil, $allowed))
		<h1 class="page-header">Reportes</h1>
		<div class="panel-group" id="accordion-reportes" role="tablist" aria-multiselectable="true">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingFive">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion-reportes" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
							Cartera vencida por edades (Contratos)
						</a>
					</h4>
				</div>
				<div id="collapseFive" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFive">
					<div class="panel-body">
						{{ Form::open(array('url' => array('business/reports/carteraedadescontratos'), 'method' => 'POST'), array('role' => 'form')) }}									
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
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
						<a class="collapsed" data-toggle="collapse" data-parent="#accordion-reportes" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
							Cartera vencida por edades (Clientes)
						</a>
					</h4>
				</div>
				<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
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
						{{ Form::open(array('url' => array('business/reports/estadocuenta'), 'method' => 'POST', 'id' => 'form-reporte-estado-cuenta'), array('role' => 'form')) }}									
							<div class="row" align="center">
								<div class="form-group col-md-1"></div>
								<div class="form-group col-md-3">
									{{ Form::label('cliente_cedula', 'Cliente') }}
						           	{{ Form::text('cliente_cedula', null, array('placeholder' => 'Ingrese cédula', 'class' => 'form-control')) }}        
						        	{{ Form::hidden('cliente', null, array('id' => 'cliente')) }}
								</div>
								<div class="form-group col-md-7">   
									{{ Form::label('cliente_nombre', 'Nombre') }}     	
						            {{ Form::text('cliente_nombre', null, array('placeholder' => 'Ingrese nombre', 'class' => 'form-control')) }}        
						        </div>
								<div class="form-group col-md-1"></div>
							</div>
							<div id="customers" class="row" align="center"></div>
							<p align="center">
								{{ Form::button('Buscar', array('class'=>'btn btn-primary', 'id' => 'btn-search-customers-reporte-estado-cuenta' )) }} 
								{{ Form::button('Generar', array('class' => 'btn btn-info', 'id' => 'btn-submit-reporte-estado-cuenta' )) }}
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
						{{ Form::open(array('url' => array('business/reports/reciboscaja'), 'method' => 'POST', 'id' => 'form-reporte-reciboscaja'), array('role' => 'form')) }}									
							<div class="row" align="center">
								<div class="form-group col-md-3">
									{{ Form::label('fecha_inicial_reciboscaja', 'Fecha Inicial') }}
						            <div class="input-append date">	
						            	{{ Form::text('fecha_inicial_reciboscaja', date('Y-m-d'), array('placeholder' => 'yyyy-mm-dd', 'class' => 'form-control')) }}        
						        	</div>
								</div>
								<div class="form-group col-md-3">
									{{ Form::label('fecha_final_reciboscaja', 'Fecha Final') }}
						            <div class="input-append date">	
						            	{{ Form::text('fecha_final_reciboscaja', date('Y-m-d'), array('placeholder' => 'yyyy-mm-dd', 'class' => 'form-control')) }}        
						        	</div>
								</div>
								<div class="form-group col-md-3">
								{{ Form::label('tipo', 'Tipo') }}
								{{ Form::select('tipo', array(
									'0' => 'Todos', 'PA' => 'Pago', 'DE' => 'Descuento', 'DV' => 'Devolución'),
									'T',array('class' => 'form-control', 'style' => 'width:30;')) 
								}}
								</div>
								<div class="form-group col-md-3">
						            {{ Form::label('grupo', 'Grupo') }}
						            {{ Form::select('grupo', array('0' => 'Seleccione') + $groups ,null, array('class' => 'form-control')) }}
						        </div>
							</div>
							<p align="center">
								{{ Form::button('Generar', array('class' => 'btn btn-info', 'id' => 'btn-submit-reporte-reciboscaja' )) }}
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
								<div class="form-group col-md-3">
									{{ Form::label('fecha_inicial', 'Fecha Inicial') }}
						            <div class="input-append date">	
						            	{{ Form::text('fecha_inicial', date('Y-m-d'), array('placeholder' => 'yyyy-mm-dd', 'class' => 'form-control')) }}        
						        	</div>
								</div>
								<div class="form-group col-md-3">
									{{ Form::label('fecha_final', 'Fecha Final') }}
						            <div class="input-append date">	
						            	{{ Form::text('fecha_final', date('Y-m-d'), array('placeholder' => 'yyyy-mm-dd', 'class' => 'form-control')) }}        
						        	</div>
								</div>
								<div class="form-group col-md-3">        	
						            {{ Form::label('detallado', '¿Detallado?') }}
						            <div>{{ Form::checkbox('detallado', 'value') }}</div>
						        </div>
								<div class="form-group col-md-3">
						            {{ Form::label('grupo', 'Grupo') }}
						            {{ Form::select('grupo', array('0' => 'Seleccione') + $groups ,null, array('class' => 'form-control')) }}
						        </div>
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

				// Reporte recibos de caja
				$("#fecha_inicial_reciboscaja").datepicker({
	                changeMonth: true,
	                changeYear: true,
	                dateFormat: "yy-mm-dd"              
            	})

            	$("#fecha_final_reciboscaja").datepicker({
	                changeMonth: true,
	                changeYear: true,
	                dateFormat: "yy-mm-dd"              
            	})

            	$("#btn-submit-reporte-reciboscaja").click(function() {
					if(!$("#fecha_inicial_reciboscaja").val()){
		            	alertify.error("Por favor seleccione fecha inicial.");
		            	return
		            }
		            if(!$("#fecha_final_reciboscaja").val()){
		            	alertify.error("Por favor seleccione fecha final.");
		            	return
		            }
					$("#form-reporte-reciboscaja").submit();
				});

            	// Reporte ventas de un periodo
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
	
				$("#btn-submit-reporte-estado-cuenta").click(function() {
		            if(!$("#cliente").val()){
		            	alertify.error("Por favor seleccione cliente.");
		            	return
		            }
					$("#form-reporte-estado-cuenta").submit();
				});

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

            	// Reporte estado de cuenta
            	$("#btn-search-customers-reporte-estado-cuenta").click(function( event ) {  
					var url = root_url + 'business/reports';	
					$.ajax({	
						url: url,		
						type : 'get',
						data: $('#form-reporte-estado-cuenta').serialize(),	
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
				})
			});
			var estadoCuenta = {
				setCustomer : function(cliente, cedula, nombre){
					$('#cliente_cedula').val(cedula)
					$('#cliente_nombre').val(nombre)
					$('#cliente').val(cliente)				
				}
			}
		</script>
	@else
		@include('denied')
	@endif
@stop