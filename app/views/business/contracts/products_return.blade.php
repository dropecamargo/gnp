<table class="table table-striped" style="width:80%" align="center">
	<thead>
		<tr>
			<th>Producto</th>
			<th>Cantidad</th>
			<th>Devolución</th>		
		</tr>	
	</thead>     	    	
	<tbody>
		@if(count($products) > 0)
			@foreach ($products as $product)
				@if($product->disponible > 0)
					<tr>
						<td width="60%;">{{ $product->nombre }}</td>
						<td width="20%;">
							{{ $product->disponible }}
							{{ Form::hidden('cantidad_'.$product->id, $product->disponible, array('id' => 'cantidad_'.$product->id)) }}
						</td>
						<td width="20%;" align="center">
							{{ Form::text('devolucion_'.$product->id,0, array('class' => 'form-control', 'style' => 'width:50%;', 'id' => 'devolucion_'.$product->id )) }}        
							<script type="text/javascript">
								$(function() {
									$("#devolucion_"+{{ $product->id }}).change(function() {
										var cantidad = $("#cantidad_"+{{ $product->id }}).val()
										var devolucion = $("#devolucion_"+{{ $product->id }}).val()
										if(!$.isNumeric(devolucion)){
							            	alertify.error("Por favor ingrese unidades devolucion validas.");
							            	$("#devolucion_"+{{ $product->id }}).val('0')
							            	return
							            }

							            if(!$.isNumeric(cantidad)){
							            	alertify.error("Error recuperando unidades disponibles - Consulte al administrador.");
							            	$("#devolucion_"+{{ $product->id }}).val('0')
							            	return
							            }

							            if(parseInt(devolucion) > parseInt(cantidad)){
							            	alertify.error("Unidades a devolver  no pueden ser mayor a unidades resgistradas en el contrato.");
							            	$("#devolucion_"+{{ $product->id }}).val('0')
							            	return
							            }
									});	
								});
							</script>
						</td>
					</tr>
				@endif
			@endforeach	
		@else
			<tr>
				<td align="center" colspan="3">Contrato no registra productos.</td>
			</tr>	
		@endif
	</tbody>
</table> 
