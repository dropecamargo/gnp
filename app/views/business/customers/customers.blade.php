<div align="center">
	{{ $customers->links() }}
</div>
<table id="table-search-customers" class="table table-striped">
	<thead>
		<tr>
			<th>Cédula</th>
			<th>Nombre</th>
			<th>Cargo</th>
			<th>Teléfono</th>		
			<th>&nbsp;</th>
		</tr>	
	</thead>     	    	
	<tbody>
		@foreach ($customers as $customer)
			<tr>
				<td>{{ $customer->cedula }}</td>
				<td>{{ $customer->nombre }}</td>
				<td>{{ $customer->cargo }}</td>
				<td>{{ $customer->telefono_casa }}</td>
				<td nowrap="nowrap">					
					<a href="{{ route('business.customers.show', $customer->id) }}" class="btn btn-info">Ver</a>
					{{--*/ $allowed = array('A') /*--}}
    				@if (in_array(Auth::user()->perfil, $allowed))
						<a href="{{ route('business.customers.edit', $customer->id) }}" class="btn btn-primary">Editar</a>	
					@endif
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
				data: $('#form-search-customers').serialize(),
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
		});
	});
</script>