@extends ('admin/layout')

@section ('title') Recibo de pago @stop

@section ('content')
	
	<h1 class="page-header">Recibo de pago</h1>

	<div class="row">
	    <div class="form-group col-md-4">
	        <a href="{{ route('business.payments.index') }}" class="btn btn-info">Lista de recibos</a>
	    </div>
  	</div>

  	<div class="row">
        <div class="form-group col-md-3">
        	<label>Número</label>
            <div>{{ $payment->numero }}</div> 
        </div>
        <div class="form-group col-md-3">
            <label>Fecha</label>
            <div>{{ $payment->fecha }}</div> 
        </div>
    </div>	
     <div class="row">
        <div class="form-group col-md-3">
            <label>Contrato</label>
            <div>{{ $contract->numero }}</div>
        </div>
        <div class="form-group col-md-6">           
            <label>Cliente</label>
            <div>{{ $customer->nombre }}</div>
        </div>
        <div class="form-group col-md-2">
            <div class="form-group col-md-4">
                <a href="{{ route('business.contracts.show', $payment->contrato) }}" class="btn btn-info">Ver contrato</a>
            </div>
        </div>        
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Cobrador</label>
            <div>{{ $collector->nombre }}</div>                
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label>Tipo</label>
            <div>{{ $payment->types[$payment->tipo] }}</div>
        </div>
        <div class="form-group col-md-3">
            <label>Valor</label>
            <div>{{ $payment->valor }}</div>
        </div>        
    </div>
	<div class="row">
        <div class="form-group col-md-4">
            <label>Creación</label>
            <div>{{ $payment->created_at }}</div>
        </div>
        <div class="form-group col-md-4">
            <label>Actualización</label>
            <div>{{ $payment->updated_at }}</div>
        </div>  
    </div>
@stop 