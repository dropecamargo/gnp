@extends ('usuario/layout')

@section ('title') User {{ $usuario->usuario_nombre }} @stop

@section ('content')

<h2>User #{{ $usuario->id }}</h2>

<p>Cuenta: {{ $usuario->usuario_cuenta }}</p>
<p>Nombre: {{ $usuario->usuario_nombre }}</p>
<p>Perfil: {{ $usuario->usuario_perfil }}</p>
<p>Activo: {{ $usuario->usuario_activo }}</p>

<p>
  <a href="{{ route('usuario.edit', $usuario->id) }}" class="btn btn-primary">
    Editar
  </a>    
</p>

{{ Form::model($usuario, array('route' => array('usuario.destroy', $usuario->id), 'method' => 'DELETE'), array('role' => 'form')) }}
  {{ Form::submit('Eliminar usuario', array('class' => 'btn btn-danger')) }}
{{ Form::close() }}

@stop