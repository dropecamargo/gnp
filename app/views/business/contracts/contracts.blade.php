<div align="center">
	{{ $contracts->links() }}
</div>
<table id="table-search-contracts" class="table table-striped">
	<thead>
		<tr>
			<th>Numero</th>
			<th>Cliente</th>
			<th>Fecha</th>
			<th>&nbsp;</th>
		</tr>	
	</thead>     	    	
	<tbody>
		@foreach ($contracts as $contract)
			<tr>
				<td>{{ $contract->numero }}</td>
				<td>{{ $contract->cliente }}</td>
				<td>{{ $contract->fecha }}</td>
				<td nowrap="nowrap">					
					<a href="{{ route('business.contracts.show', $contract->id) }}" class="btn btn-info">Ver</a>
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
				$("#contracts").empty().html(data.html);
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