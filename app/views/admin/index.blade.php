@extends('admin/layout')

@section('content')

<h1 class="page-header">Bienvenido GNP Software</h1>
<h4>{{ Auth::user()->name; }}</h4>
<span class="text-muted">{{ Auth::user()->email; }}</span>

@stop