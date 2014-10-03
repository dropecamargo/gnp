<div align="center">
	{{ $users->links() }}
</div>
<table id="table-search-users" class="table table-striped">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Cuenta</th>
			<th>Email</th>
			<th>Perfil</th>
			<th>Estado</th>
			<th>&nbsp;</th>
		</tr>	
	</thead>     	    	
	<tbody>
		@foreach ($users as $user)
			<tr>
				<td>{{ $user->name }}</td>
				<td>{{ $user->username }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->profiles[$user->perfil] }}</td>
				<td>{{ $user->states[$user->activo] }}</td>
				<td nowrap="nowrap">					
					<a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info">Ver</a>
					<a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">Editar</a>					
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
				$("#users").empty().html(data.html);
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