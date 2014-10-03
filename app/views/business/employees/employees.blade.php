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
					<a href="{{ route('business.employees.edit', $employee->id) }}" class="btn btn-primary">Editar</a>	
				</td>
			</tr>
		@endforeach
	</tbody>
</table> 