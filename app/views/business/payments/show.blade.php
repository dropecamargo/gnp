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
            <div><?php echo number_format($payment->valor, 2,'.',',' ) ?></div>
        </div> 
        <div class="form-group col-md-3">
            <label>Proximo pago</label>
            @if($payment->proxima != '0000-00-00')
                <div>{{ $payment->proxima }}</div>
            @endif
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
    @if(count($products) > 0) 
        <table id="table-employees" class="table table-striped" style="width:80%" align="center">
            <thead>
                <tr>
                    <th width="85%">Producto</th>
                    <th width="15%">Devolución</th>
                </tr>   
            </thead>                
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->nombre }}</td>
                        <td>{{ $product->devolucion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif 
@stop 