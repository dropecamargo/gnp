@extends ('admin/layout')

<?php
    if ($group->exists):
        $form_data = array('route' => array('business.groups.update', $group->id), 'method' => 'PATCH');
        $action    = 'Editar';
    else:
        $form_data = array('route' => 'business.groups.store', 'method' => 'POST');
        $action    = 'Crear';
    endif;
?>

@section ('title') {{ $action }} grupo @stop

@section ('content')

    <h1 class="page-header">{{ $action }} grupo</h1>

    <div class="row">
        <div class="form-group col-md-4">
            <a href="{{ route('business.groups.index') }}" class="btn btn-info">Lista de grupos</a>
        </div>
    </div>    

    @include ('errors', array('errors' => $errors))

    {{ Form::model($group, $form_data, array('role' => 'form')) }}
    
    <div class="row">
        <div class="form-group col-md-4">
            {{ Form::label('nombre', 'Nombre completo') }}
            {{ Form::text('nombre', null, array('placeholder' => 'Ingrese nombre', 'class' => 'form-control')) }}        
        </div>        
        <div class="form-group col-md-4">
            {{ Form::label('activo', 'Estado') }}
            {{ Form::select('activo', $group->states ,null, array('class' => 'form-control')) }}
        </div>
    </div>

    {{ Form::button($action . ' grupo', array('type' => 'submit', 'class' => 'btn btn-success')) }}        
    
    {{ Form::close() }} 
@stop