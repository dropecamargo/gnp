<div align="center">
	{{ $planillas->links() }}
</div>
<table id="table-search-contracts" class="table table-striped">
	<thead>
		<tr>
			<th>Numero</th>	
			<th>Fecha</th>
			<th>Cobrador</th>
			<th>Zona</th>		
			<th>&nbsp;</th>
		</tr>	
	</thead>     	    	
	<tbody>
		@foreach ($planillas as $planilla)
			<tr>
				<td>{{ $planilla->id }}</td>
				<td>{{ $planilla->fecha }}</td>
				<td>{{ $planilla->cobrador_nombre }}</td>
				<td>{{ $planilla->zona }}</td>
				<td nowrap="nowrap">					
					<a href="{{ route('business.planilla.show', $planilla->id) }}" class="btn btn-info">Ver</a>
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
				data: $('#form-search-planillas').serialize(),
				datatype: "html",
				beforeSend: function() {
					$('#loading-app').modal('show');
				}
			})
			.done(function(data) {				
				$('#loading-app').modal('hide');
				$("#planillas").empty().html(data.html);
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