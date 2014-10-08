@extends ('admin/layout')

@section ('title') Contrato @stop

@section ('content')
	
	<h1 class="page-header">Contrato</h1>

	<div class="row">
	    <div class="form-group col-md-4">
	        <a href="{{ route('business.contracts.index') }}" class="btn btn-info">Lista de contratos</a>
	    </div>
  	</div>

  	<div class="row">
        <div class="form-group col-md-3">
        	<label>Número</label>
            <div>{{ $contract->numero }}</div> 
        </div>
        <div class="form-group col-md-3">
            <label>Fecha</label>
            <div>{{ $contract->fecha }}</div> 
        </div>
    </div>	
	<div class="row">
        <div class="form-group col-md-3">
            <label>Cliente</label>
            <div>{{ $contract->cliente }}</div>
        </div>
        <div class="form-group col-md-6">
            <label>Nombre</label>
            <div>{{ $contract->cliente }}</div>
        </div>        
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label>Valor</label>
            <div>{{ $contract->valor }}</div>
        </div>
        <div class="form-group col-md-3">
        	<label>Cuotas</label>
            <div>{{ $contract->cuotas }}</div>
        </div> 
        <div class="form-group col-md-3">
            <label>Primera cuota</label>
            <div>{{ $contract->primera }}</div>
        </div>        
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <label>Creación</label>
            <div>{{ $contract->created_at }}</div>
        </div>
        <div class="form-group col-md-4">
            <label>Actualización</label>
            <div>{{ $contract->updated_at }}</div>
        </div>  
    </div>
@stop 