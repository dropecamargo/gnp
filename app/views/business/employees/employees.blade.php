<div align="center">
	{{ $employees->links() }}
</div>
<table id="table-employees" class="table table-striped">
	<thead>
		<tr>
			<th>Cédula</th>
			<th>Nombre</th>
			<th>Cargo</th>
			<th>Estado</th>
			<th>&nbsp;</th>
		</tr>	
	</thead>     	    	
	<tbody>
		@foreach ($employees as $employee)
			<tr>
				<td>{{ $employee->cedula }}</td>
				<td>{{ $employee->nombre }}</td>
				<td>{{ $employee->jobs[$employee->cargo] }}</td>
				<td>{{ $employee->states[$employee->activo] }}</td>
				<td nowrap="nowrap">					
					<a href="{{ route('business.employees.show', $employee->id) }}" class="btn btn-info">Ver</a>
					{{--*/ $allowed = array('A') /*--}}
    				@if (in_array(Auth::user()->perfil, $allowed))
						<a href="{{ route('business.employees.edit', $employee->id) }}" class="btn btn-primary">Editar</a>	
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
				datatype: "html",
				beforeSend: function() {
					$('#loading-app').modal('show');
				}
			})
			.done(function(data) {				
				$('#loading-app').modal('hide');
				$("#employees").empty().html(data.html);
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