@extends ('admin/layout')

@section ('title') Cliente @stop

@section ('content')
	
	<h1 class="page-header">Cliente</h1>

	<div class="row">
	    <div class="form-group col-md-4">
	        <a href="{{ route('business.customers.index') }}" class="btn btn-info">Lista de clientes</a>
	    </div>
  	</div>  

    <div class="row">
        <div class="form-group col-md-3">
            <label>Cédula</label>
            <div>{{ $customer->cedula }}</div>
        </div>
        <div class="form-group col-md-6">
            <label>Nombre completo</label>
            <div>{{ $customer->nombre }}</div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label>Dirección CASA</label>
            <div>{{ $customer->direccion_casa }}</div>
        </div>
        <div class="form-group col-md-3">
            <label>Barrio</label>
            <div>{{ $customer->barrio_casa }}</div>
        </div> 
        <div class="form-group col-md-3">
            <label>Teléfono</label>
            <div>{{ $customer->telefono_casa }}</div>
        </div>        
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label>Empresa</label>
            <div>{{ $customer->empresa }}</div>
       
        </div>
        <div class="form-group col-md-3">
            <label>Cargo</label>
            <div>{{ $customer->cargo }}</div>
        </div>        
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label>Dirección EMPRESA</label>
            <div>{{ $customer->direccion_empresa }}</div>
        </div>
        <div class="form-group col-md-3">
            <label>Barrio</label>
            <div>{{ $customer->barrio_empresa }}</div>
        </div> 
        <div class="form-group col-md-3">
            <label>Teléfono</label>
            <div>{{ $customer->telefono_empresa }}</div>
        </div>        
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label>Nombre REFERENCIA 1</label>
            <div>{{ $customer->ref1_nombre }}</div>
        </div>
        <div class="form-group col-md-3">
            <label>Parentesco</label>
            <div>{{ $customer->ref1_parentesco }}</div>
        </div> 
        <div class="form-group col-md-3">
            <label>Dirección</label>
            <div>{{ $customer->ref1_direccion }}</div>
        </div> 
        <div class="form-group col-md-3">
            <label>Teléfono</label>
            <div>{{ $customer->ref1_telefono }}</div>
        </div>        
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label>Nombre REFERENCIA 2</label>
            <div>{{ $customer->ref2_nombre }}</div>
        </div>
        <div class="form-group col-md-3">
            <label>Parentesco</label>
            <div>{{ $customer->ref2_parentesco }}</div>
        </div> 
        <div class="form-group col-md-3">
            <label>Dirección</label>
            <div>{{ $customer->ref2_direccion }}</div>
        </div> 
        <div class="form-group col-md-3">
            <label>Teléfono</label>
            <div>{{ $customer->ref2_telefono }}</div>
        </div>       
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <label>Creación</label>
            <div>{{ $customer->created_at }}</div>
        </div>
        <div class="form-group col-md-4">
            <label>Actualización</label>
            <div>{{ $customer->updated_at }}</div>
        </div>  
    </div>
    <p>         
        <a href="{{ route('business.customers.edit', $customer->id) }}" class="btn btn-success">Editar</a>      
    </p>    

@stop