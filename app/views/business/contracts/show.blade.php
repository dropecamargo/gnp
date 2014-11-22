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
            <div>{{ $customer->cedula }}</div>
        </div>
        <div class="form-group col-md-6">
            <label>Nombre</label>
            <div>{{ $customer->nombre }}</div>
        </div> 
        <div class="form-group col-md-3">
            <label>Vendedor</label>
            <div>{{ $vendor->nombre }}</div>
        </div>       
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label>Valor</label>
            <div><?php echo number_format($contract->valor, 2,'.',',' ) ?></div>
        </div>
        <div class="form-group col-md-3">
        	<label>Cuotas</label>
            <div>{{ $contract->cuotas }}</div>
        </div> 
        <div class="form-group col-md-3">
            <label>Periodicidad de pago</label>
            <div>{{ $contract->periodicidad }} días</div>
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
    @if(count($products) > 0) 
        <table id="table-employees" class="table table-striped" style="width:80%" align="center">
            <thead>
                <tr>
                    <th width="60%">Producto</th>
                    <th width="15%">Cantidad</th>
                    <th width="15%">Devolución</th>
                    <th width="10%"><span>&nbsp;</span></th>
                </tr>   
            </thead>                
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->nombre }}</td>
                        <td>{{ $product->cantidad }}</td>
                        <td>{{ $product->devolucion }}</td>
                        <td><strong>{{ $product->cantidad - $product->devolucion }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif 
    <table id="table-employees" class="table table-striped" style="width:90%" align="center">
        <thead>
            <tr>
                <th>Cuota</th>
                <th>Fecha</th>
                <th>Valor</th>
                <th>Saldo</th>
            </tr>   
        </thead>                
        <tbody>
            @foreach ($quotas as $quota)
                <tr>
                    <td>{{ $quota->cuota }}</td>
                    <td>{{ $quota->fecha }}</td>
                    <td><?php echo number_format(round($quota->valor), 2,'.',',' ) ?></td>
                    <td><?php echo number_format(round($quota->saldo), 2,'.',',' ) ?></td>
                </tr>
            @endforeach
        </tbody>
    </table> 
@stop 