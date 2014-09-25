@extends ('usuario/layout')
@section ('title') Lista de Usuarios @stop
@section ('content')
  <h1>Lista de usuarios</h1>
  <p>
    <a href="{{ route('usuario.create') }}" class="btn btn-primary">Crear un nuevo usuario</a>
  </p>
  <table class="table table-striped">
     
	{{ $usuario->links() }}
    <tr>
        <th>Cuenta</th>
        <th>Nombre</th>
		<th>Perfil</th>
		<th>Activo</th>
		<th>Acciones</th>
    </tr>
	
    @foreach ($usuario as $usuario)
    <tr>
        <td>{{ $usuario->usuario_cuenta }}</td>
        <td>{{ $usuario->usuario_nombre }}</td>
		<td>{{ $usuario->usuario_perfil }}</td>
        <td>{{ $usuario->usuario_activo }}</td>
		<td>
          <a href="{{ route('usuario.show', $usuario->id) }}" class="btn btn-info">Ver</a>
          <a href="{{ route('usuario.edit', $usuario->id) }}" class="btn btn-primary">Editar</a>
		  <a href="#" data-id="{{ $usuario->id }}" class="btn btn-danger btn-delete"> Eliminar </a>
        </td>
    </tr>
	
    @endforeach
	
  </table>
  {{ Form::open(array('route' => array('usuario.destroy', 'USUARIO_ID'), 'method' => 'DELETE', 'role' => 'form', 'id' => 'form-delete')) }}
  {{ Form::close() }}
@stop	