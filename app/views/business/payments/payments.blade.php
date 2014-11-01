<div align="center">
	{{ $payments->links() }}
</div>
<table id="table-search-payments" class="table table-striped">
	<thead>
		<tr>
			<th>Numero</th>
			<th>Fecha</th>
			<th>Contrato</th>
			<th>Cliente</th>
			<th>Valor</th>			
			<th>&nbsp;</th>
		</tr>	
	</thead>     	    	
	<tbody>
		@foreach ($payments as $payment)
			<tr>
				<td>{{ $payment->numero }}</td>
				<td>{{ $payment->fecha }}</td>
				<td>{{ $payment->contrato }}</td>
				<td>{{ $payment->cliente_nombre }}</td>
				<td><?php echo number_format($payment->valor, 2,'.',',' ) ?></td>
				<td nowrap="nowrap">					
					<a href="{{ route('business.payments.show', $payment->id) }}" class="btn btn-info">Ver</a>
				</td>
			</tr>
		@endforeach	
	</tbody>
</table> 

<script type="text/javascript">
	$(document).ready(function(){	
		$(".pagination a").click(function()
		{
			var url = $(this).attr('href');						
			$.ajax({
				url: url,
				type: "GET",
				datatype: "html",
				beforeSend: function() {
					$('#loading-app').modal('show');
				}
			})
			.done(function(data) {				
				$('#loading-app').modal('hide');
				$("#payments").empty().html(data.html);
			})
			.fail(function(jqXHR, ajaxOptions, thrownError)
			{
				$('#loading-app').modal('hide');
				$('#error-app').modal('show');
				$("#error-app-label").empty().html("No hay respuesta del servidor - Consulte al administrador.");				
			});
			return false;
		});
	});
</script>