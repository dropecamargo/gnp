<div align="center">
	{{ $customers->links() }}
</div>
<table id="table-search-customers" class="table table-striped">
	<thead>
		<tr>
			<th>Cédula</th>
			<th>Nombre</th>
		</tr>	
	</thead>     	    	
	<tbody>
		@foreach ($customers as $customer)
			<tr>
				<td class="search">
					<a href="#" onclick="estadoCuenta.setCustomer('{{$customer->id}}','{{$customer->cedula}}','{{$customer->nombre}}')">
						{{ $customer->cedula }}
					</a>
				</td>
				<td>{{ $customer->nombre }}</td>
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
				data: $('#form-reporte-estado-cuenta').serialize(),
				datatype: "html",
				beforeSend: function() {
					$('#loading-app').modal('show');
				}
			})
			.done(function(data) {				
				$('#loading-app').modal('hide');
				$("#customers").empty().html(data.html);
			})
			.fail(function(jqXHR, ajaxOptions, thrownError)
			{
				$('#loading-app').modal('hide');
				$('#error-app').modal('show');
				$("#error-app-label").empty().html("No hay respuesta del servidor - Consulte al administrador.");				
			});
			return false;
		})
	});
</script>