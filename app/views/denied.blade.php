<h1 class="page-header">Acceso denegado</h1>
<h4>{{ Auth::user()->name }}</h4>
<span class="text-muted">{{ Auth::user()->profiles[Auth::user()->perfil] }}</span>
<div align="center">
	{{ HTML::image('images/denied.png') }}
</div>