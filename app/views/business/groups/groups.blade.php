<div align="center">
	{{ $groups->links() }}
</div>
<table id="table-employees" class="table table-striped">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Estado</th>
			<th>&nbsp;</th>
		</tr>	
	</thead>     	    	
	<tbody>
		@foreach ($groups as $group)
			<tr>
				<td>{{ $group->nombre }}</td>
				<td>{{ $group->states[$group->activo] }}</td>
				<td nowrap="nowrap">					
					<a href="{{ route('business.groups.show', $group->id) }}" class="btn btn-info">Ver</a>
					{{--*/ $allowed = array('A') /*--}}
    				@if (in_array(Auth::user()->perfil, $allowed))
						<a href="{{ route('business.groups.edit', $group->id) }}" class="btn btn-primary">Editar</a>	
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
				$("#groups").empty().html(data.html);
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
