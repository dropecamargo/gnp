@extends ('admin/layout')

<?php
    if ($employee->exists):
        $form_data = array('route' => array('business.employees.update', $employee->id), 'method' => 'PATCH');
        $action    = 'Editar';
    else:
        $form_data = array('route' => 'business.employees.store', 'method' => 'POST');
        $action    = 'Crear';
    endif;
?>

@section ('title') {{ $action }} empleado @stop

@section ('content')

    <h1 class="page-header">{{ $action }} empleado</h1>

    <div class="row">
        <div class="form-group col-md-4">
            <a href="{{ route('business.employees.index') }}" class="btn btn-info">Lista de empleados</a>
        </div>
    </div>    

    @include ('errors', array('errors' => $errors))

    {{ Form::model($employee, $form_data, array('role' => 'form')) }}
    
    <div class="row">
        <div class="form-group col-md-4">
            {{ Form::label('cedula', 'Cédula') }}
            {{ Form::text('cedula', null, array('placeholder' => 'Ingrese cédula de ciudadania', 'class' => 'form-control')) }}        
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('nombre', 'Nombre completo') }}
            {{ Form::text('nombre', null, array('placeholder' => 'Ingrese nombre y apellido', 'class' => 'form-control')) }}        
        </div>        
    </div>

    <div class="row">
        <div class="form-group col-md-4">
            {{ Form::label('activo', 'Estado') }}
            {{ Form::select('activo', $employee->states ,null, array('class' => 'form-control')) }}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('cargo', 'Cargo') }}
            {{ Form::select('cargo', $employee->jobs ,null, array('class' => 'form-control')) }}
        </div>
    </div>
    {{ Form::button($action . ' empleado', array('type' => 'submit', 'class' => 'btn btn-success')) }}        
    
    {{ Form::close() }}  
@stop

